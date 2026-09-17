<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cita extends Model
{
    protected $table = 'citas';

    public const HORAS_DISPONIBLES = [
        '08:00:00', '09:00:00', '10:00:00', '11:00:00', '12:00:00',
        '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00',
    ];

    protected $fillable = [
        'mascota_id',
        'veterinario_id',
        'agendada_por',
        'fecha',
        'hora',
        'tipo_consulta',
        'estado',
        'cita_origen_id',
        'motivo_cancelacion',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }

    public function veterinario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'veterinario_id');
    }

    public function agendadaPor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'agendada_por');
    }

    public function citaOrigen(): BelongsTo
    {
        return $this->belongsTo(Cita::class, 'cita_origen_id');
    }

    public function historial(): HasMany
    {
        return $this->hasMany(HistorialClinico::class, 'cita_id');
    }

    public function scopeAgendadas($query)
    {
        return $query->where('estado', 'agendada');
    }

    public static function horarioDisponible(int $veterinarioId, string $fecha, string $hora): bool
    {
        return ! self::where('veterinario_id', $veterinarioId)
            ->where('fecha', $fecha)
            ->where('hora', $hora)
            ->where('estado', '!=', 'cancelada')
            ->exists();
    }

    public static function sugerirHorariosLibres(int $veterinarioId, string $fechaInicio): array
    {
        $sugerencias = [];
        $fecha = Carbon::parse($fechaInicio);

        for ($dias = 0; $dias <= 14; $dias++) {
            $fechaActual = $fecha->copy()->addDays($dias)->format('Y-m-d');

            foreach (self::HORAS_DISPONIBLES as $hora) {
                if (self::horarioDisponible($veterinarioId, $fechaActual, $hora)) {
                    $sugerencias[] = ['fecha' => $fechaActual, 'hora' => $hora];
                }
                if (count($sugerencias) >= 3) {
                    return $sugerencias;
                }
            }
        }

        return $sugerencias;
    }

    public static function pendientesDeHistorial(int $mascotaId)
    {
        return self::where('mascota_id', $mascotaId)
            ->where('estado', '!=', 'cancelada')
            ->whereDoesntHave('historial')
            ->orderByDesc('fecha')
            ->orderByDesc('hora')
            ->get();
    }
}
