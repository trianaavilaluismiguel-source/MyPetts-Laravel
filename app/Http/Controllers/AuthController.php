<?php

namespace App\Http\Controllers;

use App\Models\TokenRecuperacion;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function mostrarLogin()
    {
        return view('auth.login');
    }

    public function mostrarRegistro()
    {
        return view('auth.registro');
    }

    // Registro público -> siempre rol DueñoMascota (id 4)
    public function registrar(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|min:8|regex:/[A-Za-z]/|regex:/[0-9]/',
            'confirmar_contrasena' => 'required|same:contrasena',
            'telefono' => 'required',
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contrasena_hash' => Hash::make($request->contrasena),
            'telefono' => $request->telefono,
            'rol_id' => 4,
        ]);

        return redirect('/login')->with('mensaje', 'Cuenta creada. Ya puedes iniciar sesión.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required',
        ]);

        $usuario = Usuario::where('correo', $request->correo)->first();

        if (! $usuario) {
            return back()->with('error', 'Acceso denegado. El correo o la contraseña son incorrectos.');
        }

        // Bloqueo temporal por intentos fallidos
        if ($usuario->bloqueado_hasta && $usuario->bloqueado_hasta->isFuture()) {
            return back()->with('error', 'Cuenta bloqueada temporalmente. Intenta más tarde.');
        }

        if (! $usuario->activo) {
            return back()->with('error', 'Tu cuenta está desactivada. Contacta al administrador.');
        }

        if (! Hash::check($request->contrasena, $usuario->contrasena_hash)) {
            $intentos = $usuario->intentos_fallidos + 1;
            $bloqueo = $intentos >= 3 ? now()->addMinutes(5) : null;

            $usuario->update([
                'intentos_fallidos' => $intentos,
                'bloqueado_hasta' => $bloqueo,
            ]);

            $mensaje = $intentos >= 3
                ? 'Superaste el límite de intentos. Cuenta bloqueada por 5 minutos.'
                : 'Acceso denegado. El correo o la contraseña son incorrectos.';

            return back()->with('error', $mensaje);
        }

        $usuario->update(['intentos_fallidos' => 0, 'bloqueado_hasta' => null]);

        Auth::login($usuario);
        $request->session()->regenerate();

        if ($usuario->requiere_cambio_pwd) {
            return redirect('/cambiar-password');
        }

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function mostrarCambioPassword()
    {
        return view('auth.cambiar-password');
    }

    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'contrasena' => 'required|min:8|regex:/[A-Za-z]/|regex:/[0-9]/',
            'confirmar_contrasena' => 'required|same:contrasena',
        ]);

        Auth::user()->cambiarContrasena($request->contrasena);

        return redirect('/dashboard')->with('mensaje', 'Contraseña actualizada correctamente.');
    }

    public function olvidePassword()
    {
        return view('auth.olvide-password');
    }

    public function enviarRecuperacion(Request $request)
    {
        $usuario = Usuario::where('correo', $request->correo)->first();

        if ($usuario) {
            $token = Str::random(64);

            TokenRecuperacion::create([
                'usuario_id' => $usuario->id,
                'token' => $token,
                'expira_en' => now()->addMinutes(30),
            ]);

            // TODO: enviar correo real (siguiente paso: Mailable)
        }

        return back()->with('mensaje', 'Si el correo está registrado, se envió un enlace de recuperación.');
    }

    public function restablecer(string $token)
    {
        $registro = TokenRecuperacion::where('token', $token)->first();

        if (! $registro || ! $registro->estaVigente()) {
            return view('auth.restablecer-password', ['token' => null, 'error' => 'El enlace no es válido o ya expiró.']);
        }

        return view('auth.restablecer-password', ['token' => $token]);
    }

    public function procesarRestablecer(Request $request, string $token)
    {
        $registro = TokenRecuperacion::where('token', $token)->first();

        if (! $registro || ! $registro->estaVigente()) {
            return view('auth.restablecer-password', ['token' => null, 'error' => 'El enlace no es válido o ya expiró.']);
        }

        $request->validate([
            'contrasena' => 'required|min:8|regex:/[A-Za-z]/|regex:/[0-9]/',
            'confirmar_contrasena' => 'required|same:contrasena',
        ]);

        $registro->usuario->cambiarContrasena($request->contrasena);
        $registro->update(['usado' => true]);

        return redirect('/login')->with('mensaje', 'Contraseña restablecida. Ya puedes iniciar sesión.');
    }
}
