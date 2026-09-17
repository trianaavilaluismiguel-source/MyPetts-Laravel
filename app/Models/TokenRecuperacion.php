<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TokenRecuperacion extends Model
{
    public $timestamps = false;

    protected $table = 'tokens_recuperacion';

    protected $fillable = [
        'usuario_id',
        'token',
        'expira_en',
        'usado',
    ];

    protected $casts = [
        'expira_en' => 'datetime',
        'usado' => 'boolean',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function estaVigente(): bool
    {
        return ! $this->usado && $this->expira_en->isFuture();
    }
}
