<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    protected $fillable = [
        'dueno_id', 'nombre', 'especie', 'raza',
        'fecha_nacimiento', 'sexo', 'peso', 'estado_salud', 'activa',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'activa' => 'boolean',
    ];

    public function dueno()
    {
        return $this->belongsTo(Usuario::class, 'dueno_id');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function historial()
    {
        return $this->hasMany(HistorialClinico::class);
    }

    public function vacunas()
    {
        return $this->hasMany(VacunaDesparasitacion::class);
    }

    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }

    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento->age;
    }
}
