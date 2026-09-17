<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Mascota;
use App\Models\Notificacion;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $rolId = (int) $usuario->rol_id;

        $mascotas = collect();
        $citas = collect();
        $totalMascotas = 0;
        $totalUsuarios = 0;
        $avisosFallidos = collect();

        if ($rolId === 4) { // DueñoMascota
            $mascotas = Mascota::activas()->where('dueno_id', $usuario->id)->get();
            $citas = Cita::with('veterinario')
                ->whereHas('mascota', fn ($q) => $q->where('dueno_id', $usuario->id))
                ->agendadas()
                ->where('fecha', '>=', now()->toDateString())
                ->orderBy('fecha')->orderBy('hora')
                ->limit(5)->get();

            $avisosFallidos = Notificacion::where('usuario_id', $usuario->id)
                ->where('estado', 'fallido')
                ->pendientes()
                ->get();

            if ($avisosFallidos->isNotEmpty()) {
                Notificacion::where('usuario_id', $usuario->id)
                    ->pendientes()
                    ->update(['mostrada_en_login' => true]);
            }
        } elseif ($rolId === 2) { // Veterinario
            $citas = Cita::with('mascota')
                ->where('veterinario_id', $usuario->id)
                ->agendadas()
                ->where('fecha', '>=', now()->toDateString())
                ->orderBy('fecha')->orderBy('hora')
                ->limit(5)->get();
        } else { // Recepcionista o Administrador
            $totalMascotas = Mascota::activas()->count();
            $totalUsuarios = Usuario::count();
            $citas = Cita::with(['mascota', 'veterinario'])
                ->agendadas()
                ->where('fecha', '>=', now()->toDateString())
                ->orderBy('fecha')->orderBy('hora')
                ->limit(8)->get();
        }

        return view('dashboard.index', [
            'usuario' => $usuario,
            'rolId' => $rolId,
            'mascotas' => $mascotas,
            'citas' => $citas,
            'totalMascotas' => $totalMascotas,
            'totalUsuarios' => $totalUsuarios,
            'avisosFallidos' => $avisosFallidos,
        ]);
    }
}
