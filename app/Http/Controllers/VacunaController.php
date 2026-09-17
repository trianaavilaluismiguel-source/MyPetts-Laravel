<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Mascota;
use App\Models\VacunaDesparasitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VacunaController extends Controller
{
    private const ROL_VETERINARIO = 2;

    private const ROL_DUENO = 4;

    public function listar()
    {
        $rolId = (int) Auth::user()->rol_id;
        $query = Mascota::query()->activas()->orderBy('nombre');

        if ($rolId === self::ROL_DUENO) {
            $query->where('dueno_id', Auth::id());
        } elseif ($rolId === self::ROL_VETERINARIO) {
            $query->whereHas('citas', fn ($q) => $q->where('veterinario_id', Auth::id()));
        }

        $mascotas = $query->paginate(9)->withQueryString();

        return view('vacunas.listar', ['mascotas' => $mascotas]);
    }

    public function verVacunas(int $mascotaId)
    {
        $mascota = Mascota::findOrFail($mascotaId);
        $this->verificarPropiedad($mascota);

        $registros = VacunaDesparasitacion::where('mascota_id', $mascotaId)
            ->orderByDesc('fecha_aplicacion')
            ->paginate(8)
            ->withQueryString();

        return view('vacunas.index', ['mascota' => $mascota, 'registros' => $registros]);
    }

    public function mostrarCrear(Request $request, int $mascotaId)
    {
        $mascota = Mascota::findOrFail($mascotaId);
        $citaId = $request->query('cita_id');
        $cita = $citaId ? $this->citaValidaParaVacuna($citaId, $mascotaId) : null;

        return view('vacunas.crear', [
            'mascota' => $mascota,
            'cita' => $cita,
        ]);
    }

    public function crear(Request $request, int $mascotaId)
    {
        $mascota = Mascota::findOrFail($mascotaId);
        $citaId = $request->query('cita_id');
        $cita = $citaId ? $this->citaValidaParaVacuna($citaId, $mascotaId) : null;

        $reglas = [
            'nombre_producto' => 'required',
            'lote' => 'required',
            'fecha_aplicacion' => 'required|date|before_or_equal:today',
            'fecha_proxima_dosis' => 'required|date|after:fecha_aplicacion',
        ];

        if (! $cita) {
            $reglas['tipo'] = 'required|in:vacuna,desparasitacion';
        }

        $datos = $request->validate($reglas);

        $tipo = $cita
            ? ($cita->tipo_consulta === 'Vacunación' ? 'vacuna' : 'desparasitacion')
            : $datos['tipo'];

        VacunaDesparasitacion::create([
            'mascota_id' => $mascotaId,
            'historial_id' => null,
            'veterinario_id' => Auth::id(),
            'tipo' => $tipo,
            'nombre_producto' => $datos['nombre_producto'],
            'lote' => $datos['lote'],
            'fecha_aplicacion' => $datos['fecha_aplicacion'],
            'fecha_proxima_dosis' => $datos['fecha_proxima_dosis'],
        ]);

        if ($cita) {
            $cita->update(['estado' => 'completada']);
        }

        return redirect("/vacuna/verVacunas/{$mascotaId}")
            ->with('mensaje', 'El registro fue guardado correctamente.');
    }

    // Valida que la cita sea del veterinario logueado, esté agendada, para esta mascota,
    // y sea de tipo Vacunación/Desparasitación — así solo se llega aquí desde "Atender"
    private function citaValidaParaVacuna($citaId, int $mascotaId): Cita
    {
        $cita = Cita::where('id', $citaId)
            ->where('mascota_id', $mascotaId)
            ->where('veterinario_id', Auth::id())
            ->where('estado', 'agendada')
            ->whereIn('tipo_consulta', ['Vacunación', 'Desparasitación'])
            ->first();

        if (! $cita) {
            abort(403, 'Esta cita no es válida para registrar una vacuna/desparasitación.');
        }

        return $cita;
    }

    private function verificarPropiedad(Mascota $mascota): void
    {
        $rolId = (int) Auth::user()->rol_id;

        if ($rolId === self::ROL_DUENO) {
            if ($mascota->dueno_id !== Auth::id()) {
                abort(403, 'No tienes permiso para ver las vacunas de esta mascota.');
            }

            return;
        }

        if ($rolId === self::ROL_VETERINARIO && ! $mascota->citas()->where('veterinario_id', Auth::id())->exists()) {
            abort(403, 'No tienes permiso para ver las vacunas de esta mascota.');
        }
    }
}
