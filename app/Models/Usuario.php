<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'correo',
        'contrasena_hash',
        'telefono',
        'rol_id',
        'activo',
        'intentos_fallidos',
        'bloqueado_hasta',
        'requiere_cambio_pwd',
        'creado_por',
    ];

    protected $hidden = [
        'contrasena_hash',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'requiere_cambio_pwd' => 'boolean',
        'bloqueado_hasta' => 'datetime',
    ];

    public function getAuthPassword(): string
    {
        return $this->contrasena_hash;
    }

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'creado_por');
    }

    public function mascotas(): HasMany
    {
        return $this->hasMany(Mascota::class, 'dueno_id');
    }

    public function citasComoVeterinario(): HasMany
    {
        return $this->hasMany(Cita::class, 'veterinario_id');
    }

    public function tokensRecuperacion(): HasMany
    {
        return $this->hasMany(TokenRecuperacion::class, 'usuario_id');
    }

    public function notificaciones(): HasMany
    {
        return $this->hasMany(Notificacion::class, 'usuario_id');
    }

    public static function crearPorAdmin(string $nombre, string $correo, string $telefono, int $rolId, int $creadoPor): array
    {
        $temporal = Str::random(8);

        $usuario = self::create([
            'nombre' => $nombre,
            'correo' => $correo,
            'contrasena_hash' => bcrypt($temporal),
            'telefono' => $telefono,
            'rol_id' => $rolId,
            'requiere_cambio_pwd' => true,
            'creado_por' => $creadoPor,
        ]);

        return ['usuario' => $usuario, 'contrasena_temporal' => $temporal];
    }

    public function resetearContrasena(): string
    {
        $temporal = Str::random(8);

        $this->update([
            'contrasena_hash' => bcrypt($temporal),
            'requiere_cambio_pwd' => true,
        ]);

        return $temporal;
    }

    public function cambiarContrasena(string $contrasenaPlana): bool
    {
        return $this->update([
            'contrasena_hash' => bcrypt($contrasenaPlana),
            'requiere_cambio_pwd' => false,
        ]);
    }
}
