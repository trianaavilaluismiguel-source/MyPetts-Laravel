<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificacion extends Model
{
    public $timestamps = false;

    protected $table = 'notificaciones';

    protected $fillable = [
        'usuario_id',
        'tipo',
        'referencia_tipo',
        'referencia_id',
        'mensaje',
        'estado',
        'mostrada_en_login',
        'fecha_envio',
    ];

    protected $casts = [
        'mostrada_en_login' => 'boolean',
        'fecha_envio' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function scopePendientes($query)
    {
        return $query->where('mostrada_en_login', false);
    }
}
