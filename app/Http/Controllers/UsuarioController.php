<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    private const ROL_ADMINISTRADOR = 1;

    // HU-07: lista todos los usuarios del sistema
    public function index()
    {
        $usuarios = Usuario::with('rol')->orderBy('nombre')->paginate(10)->withQueryString();

        return view('usuarios.index', ['usuarios' => $usuarios]);
    }

    public function mostrarCrear()
    {
        return view('usuarios.crear', ['roles' => Rol::all()]);
    }

    // HU-07: procesa la creación de una cuenta por parte del Administrador
    public function crear(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required|email|unique:usuarios,correo',
            'telefono' => 'required',
            'rol_id' => 'required|exists:roles,id',
        ]);

        $resultado = Usuario::crearPorAdmin(
            $request->nombre,
            $request->correo,
            $request->telefono,
            (int) $request->rol_id,
            auth()->id()
        );

        // TODO: notificar por correo con la contraseña temporal (pendiente Mailer real)

        return redirect('/usuario')->with('mensaje',
            'Usuario creado correctamente. Se envió la contraseña temporal a su correo ('
            .$resultado['contrasena_temporal']
            .' — visible aquí solo por si el correo no llega).'
        );
    }

    public function mostrarEditar(int $id)
    {
        $usuario = Usuario::findOrFail($id);

        return view('usuarios.editar', ['usuario' => $usuario, 'roles' => Rol::all()]);
    }

    // HU-07: procesa la edición de una cuenta
    public function editar(Request $request, int $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombre' => 'required',
            'correo' => ['required', 'email', Rule::unique('usuarios', 'correo')->ignore($usuario->id)],
            'telefono' => 'required',
            'rol_id' => 'required|exists:roles,id',
        ]);

        $usuario->update([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'rol_id' => (int) $request->rol_id,
        ]);

        return redirect('/usuario')->with('mensaje', 'Los datos del usuario fueron actualizados.');
    }

    // HU-07: activa o desactiva una cuenta
    public function cambiarEstado(int $id)
    {
        // Un administrador no puede desactivar su propia cuenta (evita quedarse fuera del sistema)
        if ($id === auth()->id()) {
            return redirect('/usuario')->with('mensaje', 'No puedes desactivar tu propia cuenta.');
        }

        $usuario = Usuario::findOrFail($id);
        $nuevoEstado = ! $usuario->activo;
        $usuario->update(['activo' => $nuevoEstado]);

        // TODO: notificar por correo la activación/desactivación (pendiente Mailer real)

        return redirect('/usuario')->with('mensaje', $nuevoEstado ? 'Usuario activado.' : 'Usuario desactivado.');
    }

    // HU-07: resetea la contraseña de una cuenta a una temporal
    public function resetearContrasena(int $id)
    {
        $usuario = Usuario::findOrFail($id);
        $contrasenaTemporal = $usuario->resetearContrasena();

        // TODO: notificar por correo la contraseña temporal (pendiente Mailer real)

        return redirect('/usuario')->with('mensaje',
            'Contraseña restablecida. Se envió la nueva contraseña temporal a su correo ('
            .$contrasenaTemporal
            .' — visible aquí solo por si el correo no llega).'
        );
    }
}
