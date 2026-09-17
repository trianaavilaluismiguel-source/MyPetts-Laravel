<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\HistorialClinico;
use App\Models\Mascota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistorialController extends Controller
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

        return view('historial.listar', ['mascotas' => $mascotas]);
    }

    public function verHistorial(Request $request, int $mascotaId)
    {
        $mascota = Mascota::findOrFail($mascotaId);
        $this->verificarPropiedad($mascota);

        $filtros = [
            'desde' => trim($request->query('desde', '')),
            'hasta' => trim($request->query('hasta', '')),
            'tipo_consulta' => trim($request->query('tipo_consulta', '')),
            'diagnostico' => trim($request->query('diagnostico', '')),
        ];

        $query = HistorialClinico::with('veterinario')
            ->where('mascota_id', $mascotaId);

        if ($filtros['desde'] !== '') {
            $query->whereDate('fecha_registro', '>=', $filtros['desde']);
        }
        if ($filtros['hasta'] !== '') {
            $query->whereDate('fecha_registro', '<=', $filtros['hasta']);
        }
        if ($filtros['tipo_consulta'] !== '') {
            $query->where('tipo_consulta', $filtros['tipo_consulta']);
        }
        if ($filtros['diagnostico'] !== '') {
            $query->where('diagnostico', 'like', '%'.$filtros['diagnostico'].'%');
        }

        $entradas = $query->orderByDesc('fecha_registro')->paginate(6)->withQueryString();

        return view('historial.index', [
            'mascota' => $mascota,
            'entradas' => $entradas,
            'filtros' => $filtros,
            'tiposConsulta' => HistorialClinico::TIPOS_CONSULTA,
        ]);
    }

    // Solo se llega aquí desde CitaController::atender() con ?cita_id=...
    public function mostrarCrear(Request $request, int $mascotaId)
    {
        $mascota = Mascota::findOrFail($mascotaId);
        $cita = $this->citaValidaParaHistorial($request, $mascotaId);

        return view('historial.crear', [
            'mascota' => $mascota,
            'cita' => $cita,
        ]);
    }

    public function crear(Request $request, int $mascotaId)
    {
        $mascota = Mascota::findOrFail($mascotaId);
        $cita = $this->citaValidaParaHistorial($request, $mascotaId);

        $datos = $request->validate([
            'motivo_consulta' => 'required',
            'diagnostico' => 'required',
            'tratamiento' => 'required',
            'observaciones' => 'nullable',
        ]);

        HistorialClinico::create([
            'mascota_id' => $mascotaId,
            'cita_id' => $cita->id,
            'veterinario_id' => Auth::id(),
            'tipo_consulta' => $cita->tipo_consulta,
            'motivo_consulta' => $datos['motivo_consulta'],
            'diagnostico' => $datos['diagnostico'],
            'tratamiento' => $datos['tratamiento'],
            'observaciones' => $datos['observaciones'] ?? null,
            'fecha_registro' => now(),
        ]);

        $cita->update(['estado' => 'completada']);

        return redirect("/historial/verHistorial/{$mascotaId}")
            ->with('mensaje', 'La entrada clínica fue registrada correctamente.');
    }

    public function mostrarEditar(int $id)
    {
        $entrada = HistorialClinico::findOrFail($id);

        if ((int) Auth::user()->rol_id !== 2 || $entrada->veterinario_id !== Auth::id()) {
            abort(403, 'No tienes permiso para editar esta entrada.');
        }

        if (! $entrada->puedeEditar()) {
            return redirect("/historial/verHistorial/{$entrada->mascota_id}")
                ->with('mensaje', 'Esta entrada ya no se puede editar: pasaron más de 24 horas desde su registro.');
        }

        return view('historial.editar', [
            'entrada' => $entrada,
            'tiposConsulta' => HistorialClinico::TIPOS_CONSULTA,
        ]);
    }

    public function editar(Request $request, int $id)
    {
        $entrada = HistorialClinico::findOrFail($id);

        if ((int) Auth::user()->rol_id !== 2 || $entrada->veterinario_id !== Auth::id()) {
            abort(403, 'No tienes permiso para editar esta entrada.');
        }

        if (! $entrada->puedeEditar()) {
            return redirect("/historial/verHistorial/{$entrada->mascota_id}")
                ->with('mensaje', 'Esta entrada ya no se puede editar: pasaron más de 24 horas desde su registro.');
        }

        $datos = $request->validate([
            'tipo_consulta' => 'required|in:'.implode(',', HistorialClinico::TIPOS_CONSULTA),
            'motivo_consulta' => 'required',
            'diagnostico' => 'required',
            'tratamiento' => 'required',
            'observaciones' => 'nullable',
        ]);

        $entrada->update($datos + [
            'fecha_ultima_edicion' => now(),
            'editado_por' => Auth::id(),
        ]);

        return redirect("/historial/verHistorial/{$entrada->mascota_id}")
            ->with('mensaje', 'La entrada clínica fue actualizada correctamente.');
    }

    // Verifica que exista una cita AGENDADA de ESTE veterinario, para ESTA mascota,
    // que aún no tenga historial, y que NO sea de tipo Vacunación/Desparasitación
    // (esas se registran directo como vacuna, ver VacunaController)
    private function citaValidaParaHistorial(Request $request, int $mascotaId): Cita
    {
        $citaId = $request->query('cita_id');

        if (! $citaId) {
            abort(403, 'Solo puedes registrar historial clínico desde una cita atendida.');
        }

        $cita = Cita::where('id', $citaId)
            ->where('mascota_id', $mascotaId)
            ->where('veterinario_id', Auth::id())
            ->where('estado', 'agendada')
            ->whereNotIn('tipo_consulta', ['Vacunación', 'Desparasitación'])
            ->whereDoesntHave('historial')
            ->first();

        if (! $cita) {
            abort(403, 'Esta cita no es válida para registrar historial clínico.');
        }

        return $cita;
    }

    private function verificarPropiedad(Mascota $mascota): void
    {
        $rolId = (int) Auth::user()->rol_id;

        if ($rolId === self::ROL_DUENO) {
            if ($mascota->dueno_id !== Auth::id()) {
                abort(403, 'No tienes permiso para ver el historial de esta mascota.');
            }

            return;
        }

        if ($rolId === self::ROL_VETERINARIO && ! $mascota->citas()->where('veterinario_id', Auth::id())->exists()) {
            abort(403, 'No tienes permiso para ver el historial de esta mascota.');
        }
    }
}
