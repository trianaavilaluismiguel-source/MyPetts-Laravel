<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HistorialClinico extends Model
{
    public $timestamps = false;

    protected $table = 'historial_clinico';

    public const TIPOS_CONSULTA = ['Consulta general', 'Control', 'Urgencia', 'Cirugía', 'Vacunación', 'Desparasitación'];

    protected $fillable = [
        'mascota_id',
        'cita_id',
        'veterinario_id',
        'tipo_consulta',
        'motivo_consulta',
        'diagnostico',
        'tratamiento',
        'observaciones',
        'fecha_registro',
        'fecha_ultima_edicion',
        'editado_por',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'fecha_ultima_edicion' => 'datetime',
    ];

    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }

    public function cita(): BelongsTo
    {
        return $this->belongsTo(Cita::class, 'cita_id');
    }

    public function veterinario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'veterinario_id');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'editado_por');
    }

    public function vacunas(): HasMany
    {
        return $this->hasMany(VacunaDesparasitacion::class, 'historial_id');
    }

    public function puedeEditar(): bool
    {
        return $this->fecha_registro->diffInHours(now()) <= 24;
    }
}
