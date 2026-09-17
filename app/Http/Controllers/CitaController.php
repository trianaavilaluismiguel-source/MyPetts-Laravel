<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\HistorialClinico;
use App\Models\Mascota;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    private const ROL_ADMINISTRADOR = 1;

    private const ROL_VETERINARIO = 2;

    private const ROL_RECEPCIONISTA = 3;

    private const ROL_DUENO = 4;

    public function index()
    {
        $rolId = (int) Auth::user()->rol_id;

        $query = Cita::with(['mascota', 'veterinario'])
            ->orderByRaw('(fecha < CURDATE()) ASC, fecha ASC, hora ASC');

        if ($rolId === self::ROL_DUENO) {
            $query->whereHas('mascota', fn ($q) => $q->where('dueno_id', Auth::id()));
        } elseif ($rolId === self::ROL_VETERINARIO) {
            $query->where('veterinario_id', Auth::id());
        }

        $citas = $query->paginate(10);

        return view('citas.index', ['citas' => $citas]);
    }

    public function mostrarCrear()
    {
        $rolId = (int) Auth::user()->rol_id;

        $mascotas = $rolId === self::ROL_DUENO
            ? Mascota::activas()->where('dueno_id', Auth::id())->get()
            : Mascota::activas()->get();

        $veterinarios = Usuario::where('rol_id', self::ROL_VETERINARIO)->get();

        return view('citas.crear', [
            'mascotas' => $mascotas,
            'veterinarios' => $veterinarios,
            'horasDisponibles' => Cita::HORAS_DISPONIBLES,
            'tiposConsulta' => HistorialClinico::TIPOS_CONSULTA,
        ]);
    }

    public function crear(Request $request)
    {
        $datos = $request->validate([
            'mascota_id' => 'required|exists:mascotas,id',
            'veterinario_id' => 'required|exists:usuarios,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required',
            'tipo_consulta' => 'required|in:'.implode(',', HistorialClinico::TIPOS_CONSULTA),
        ]);

        if (Carbon::parse($datos['fecha'].' '.$datos['hora'])->isPast()) {
            return back()->withInput()->withErrors(['hora' => 'No puedes agendar en una fecha/hora pasada.']);
        }

        if (! Cita::horarioDisponible((int) $datos['veterinario_id'], $datos['fecha'], $datos['hora'])) {
            $sugerencias = Cita::sugerirHorariosLibres((int) $datos['veterinario_id'], $datos['fecha']);

            return back()->withInput()
                ->withErrors(['hora' => 'Horario no disponible.'])
                ->with('sugerencias', $sugerencias);
        }

        Cita::create($datos + [
            'agendada_por' => Auth::id(),
            'estado' => 'agendada',
        ]);

        // TODO: notificar por correo al dueño y al veterinario (pendiente Mailer real)

        return redirect('/cita')->with('mensaje', 'La cita fue agendada correctamente.');
    }

    public function cancelar(int $id)
    {
        $cita = Cita::findOrFail($id);
        $this->verificarPropiedad($cita);

        $fechaHoraCita = Carbon::parse($cita->fecha->format('Y-m-d').' '.$cita->hora);
        $horasRestantes = now()->diffInHours($fechaHoraCita, false);

        if ($horasRestantes < 24) {
            return redirect('/cita')->with('mensaje', 'Cancelación tardía. Por favor, contacte directamente a la clínica para gestionar el cambio.');
        }

        $cita->update(['estado' => 'cancelada', 'motivo_cancelacion' => 'Cancelada por el usuario']);

        // TODO: notificar por correo (pendiente Mailer real)

        return redirect('/cita')->with('mensaje', 'La cita fue cancelada correctamente.');
    }

    public function mostrarReagendar(int $id)
    {
        $cita = Cita::findOrFail($id);
        $this->verificarPropiedad($cita);

        return view('citas.reagendar', [
            'cita' => $cita,
            'horasDisponibles' => Cita::HORAS_DISPONIBLES,
        ]);
    }

    public function reagendar(Request $request, int $id)
    {
        $cita = Cita::findOrFail($id);
        $this->verificarPropiedad($cita);

        $datos = $request->validate([
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required',
        ]);

        if (Carbon::parse($datos['fecha'].' '.$datos['hora'])->isPast()) {
            return back()->withInput()->withErrors(['hora' => 'No puedes agendar en una fecha/hora pasada.']);
        }

        if (! Cita::horarioDisponible((int) $cita->veterinario_id, $datos['fecha'], $datos['hora'])) {
            $sugerencias = Cita::sugerirHorariosLibres((int) $cita->veterinario_id, $datos['fecha']);

            return back()->withInput()
                ->withErrors(['hora' => 'Horario no disponible.'])
                ->with('sugerencias', $sugerencias);
        }

        Cita::create([
            'mascota_id' => $cita->mascota_id,
            'veterinario_id' => $cita->veterinario_id,
            'agendada_por' => $cita->agendada_por,
            'fecha' => $datos['fecha'],
            'hora' => $datos['hora'],
            'tipo_consulta' => $cita->tipo_consulta,
            'estado' => 'agendada',
            'cita_origen_id' => $cita->id,
        ]);

        $cita->update(['estado' => 'reagendada']);

        // TODO: notificar por correo (pendiente Mailer real)

        return redirect('/cita')->with('mensaje', 'La cita fue reagendada correctamente.');
    }

    // Según el tipo de consulta, "Atender" lleva a registrar vacuna/desparasitación
    // directamente, o al historial clínico para el resto de casos.
    public function atender(int $id)
    {
        $cita = Cita::findOrFail($id);

        if ($cita->veterinario_id !== Auth::id()) {
            abort(403, 'No tienes permiso para atender esta cita.');
        }

        if ($cita->estado !== 'agendada') {
            return redirect('/cita')->with('mensaje', 'Esta cita ya no está agendada, no se puede atender.');
        }

        if (in_array($cita->tipo_consulta, ['Vacunación', 'Desparasitación'])) {
            return redirect("/vacuna/mostrarCrear/{$cita->mascota_id}?cita_id={$cita->id}");
        }

        return redirect("/historial/mostrarCrear/{$cita->mascota_id}?cita_id={$cita->id}");
    }

    private function verificarPropiedad(Cita $cita): void
    {
        if ((int) Auth::user()->rol_id !== self::ROL_DUENO) {
            return;
        }

        if ($cita->mascota->dueno_id !== Auth::id()) {
            abort(403, 'No tienes permiso para modificar esta cita.');
        }
    }
}
