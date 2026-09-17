<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\Mascota;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('Demo1234!');
        $usuariosPorRol = [
            'Administrador' => 'admin',
            'Veterinario' => 'veterinario',
            'Recepcionista' => 'recepcionista',
            'DueñoMascota' => 'dueno',
        ];
        $usuarios = [];

        foreach ($usuariosPorRol as $nombreRol => $prefijo) {
            $rolId = Rol::where('nombre_rol', $nombreRol)->value('id');

            if ($rolId === null) {
                continue;
            }

            for ($indice = 1; $indice <= 5; $indice++) {
                $usuarios[$prefijo][] = Usuario::updateOrCreate(
                    ['correo' => "demo.{$prefijo}.{$indice}@mypetts.test"],
                    [
                        'nombre' => "Demo {$nombreRol} {$indice}",
                        'contrasena_hash' => $password,
                        'telefono' => '300000'.str_pad((string) $indice, 4, '0', STR_PAD_LEFT),
                        'rol_id' => $rolId,
                        'activo' => true,
                        'requiere_cambio_pwd' => false,
                    ]
                );
            }
        }

        $administradorPrincipal = $usuarios['admin'][0] ?? null;

        if ($administradorPrincipal !== null) {
            Usuario::whereIn('id', collect($usuarios)->flatten()->pluck('id'))
                ->where('id', '!=', $administradorPrincipal->id)
                ->update(['creado_por' => $administradorPrincipal->id]);
        }

        $mascotas = [];
        $especies = [
            ['especie' => 'Perro', 'raza' => 'Criollo'],
            ['especie' => 'Gato', 'raza' => 'Siamés'],
        ];

        foreach ($usuarios['dueno'] ?? [] as $indice => $dueno) {
            for ($numero = 1; $numero <= 2; $numero++) {
                $datosEspecie = $especies[($indice + $numero) % count($especies)];
                $mascotas[] = Mascota::updateOrCreate(
                    ['dueno_id' => $dueno->id, 'nombre' => "Mascota Demo {$indice}-{$numero}"],
                    [
                        'especie' => $datosEspecie['especie'],
                        'raza' => $datosEspecie['raza'],
                        'fecha_nacimiento' => now()->subYears($numero + 1)->subMonths($indice),
                        'sexo' => $numero === 1 ? 'Macho' : 'Hembra',
                        'peso' => 4.5 + ($indice * 0.8) + $numero,
                        'estado_salud' => $numero === 1 ? 'al_dia' : 'pendiente_atencion',
                        'activa' => true,
                    ]
                );
            }
        }

        foreach ($mascotas as $indice => $mascota) {
            $veterinario = $usuarios['veterinario'][$indice % count($usuarios['veterinario'])];
            $fecha = $indice < 5
                ? now()->addDays($indice + 2)
                : now()->subDays($indice - 3);
            $estados = ['agendada', 'completada', 'cancelada', 'reagendada'];

            Cita::updateOrCreate(
                [
                    'veterinario_id' => $veterinario->id,
                    'fecha' => $fecha->toDateString(),
                    'hora' => Cita::HORAS_DISPONIBLES[$indice % count(Cita::HORAS_DISPONIBLES)],
                ],
                [
                    'mascota_id' => $mascota->id,
                    'agendada_por' => $mascota->dueno_id,
                    'tipo_consulta' => $indice % 2 === 0 ? 'Consulta general' : 'Control',
                    'estado' => $estados[$indice % count($estados)],
                    'motivo_cancelacion' => $indice % count($estados) === 2 ? 'Reprogramación solicitada' : null,
                ]
            );
        }
    }
}
