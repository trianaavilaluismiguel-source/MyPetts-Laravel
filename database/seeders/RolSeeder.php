<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nombre_rol' => 'Administrador', 'descripcion' => 'Gestiona usuarios, reportes y estadísticas del sistema'],
            ['nombre_rol' => 'Veterinario', 'descripcion' => 'Registra historial clínico, vacunas y atiende citas'],
            ['nombre_rol' => 'Recepcionista', 'descripcion' => 'Gestiona mascotas y agenda de citas'],
            ['nombre_rol' => 'DueñoMascota', 'descripcion' => 'Registra sus mascotas y agenda sus citas'],
        ];

        foreach ($roles as $rol) {
            DB::table('roles')->updateOrInsert(
                ['nombre_rol' => $rol['nombre_rol']],
                ['descripcion' => $rol['descripcion']]
            );
        }
    }
}
