<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReporteGenerado extends Model
{
    public $timestamps = false;

    protected $table = 'reportes_generados';

    protected $fillable = [
        'usuario_id',
        'tipo_reporte',
        'fecha_inicio',
        'fecha_fin',
        'formato_exportacion',
        'generado_en',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'generado_en' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
