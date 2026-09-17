<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VacunaDesparasitacion extends Model
{
    public $timestamps = false;

    protected $table = 'vacunas_desparasitaciones';

    protected $fillable = [
        'mascota_id',
        'historial_id',
        'veterinario_id',
        'tipo',
        'nombre_producto',
        'lote',
        'fecha_aplicacion',
        'fecha_proxima_dosis',
        'aplicada_siguiente',
    ];

    protected $casts = [
        'fecha_aplicacion' => 'date',
        'fecha_proxima_dosis' => 'date',
        'aplicada_siguiente' => 'boolean',
    ];

    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }

    public function historial(): BelongsTo
    {
        return $this->belongsTo(HistorialClinico::class, 'historial_id');
    }

    public function veterinario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'veterinario_id');
    }

    public function scopeVencidas($query)
    {
        return $query->where('fecha_proxima_dosis', '<', now())
            ->where('aplicada_siguiente', false);
    }

    public function getEstadoAlertaAttribute(): string
    {
        if ($this->fecha_proxima_dosis->isPast()) {
            return 'vencida';
        }
        if ($this->fecha_proxima_dosis->lte(now()->addDays(30))) {
            return 'proxima';
        }

        return 'vigente';
    }
}
