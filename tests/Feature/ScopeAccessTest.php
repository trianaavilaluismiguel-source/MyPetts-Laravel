<?php

namespace Tests\Feature;

use App\Models\Cita;
use App\Models\Mascota;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ScopeAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_veterinario_only_sees_mascotas_and_records_own_scope(): void
    {
        DB::table('roles')->insert([
            ['id' => 1, 'nombre_rol' => 'Administrador', 'descripcion' => 'Admin'],
            ['id' => 2, 'nombre_rol' => 'Veterinario', 'descripcion' => 'Veterinario'],
            ['id' => 3, 'nombre_rol' => 'Recepcionista', 'descripcion' => 'Recepcionista'],
            ['id' => 4, 'nombre_rol' => 'DueñoMascota', 'descripcion' => 'Dueño'],
        ]);

        $vet = Usuario::create([
            'nombre' => 'Vet Uno',
            'correo' => 'vet1@example.com',
            'contrasena_hash' => bcrypt('secret123'),
            'telefono' => '111111111',
            'rol_id' => 2,
            'activo' => true,
        ]);

        $otherVet = Usuario::create([
            'nombre' => 'Vet Dos',
            'correo' => 'vet2@example.com',
            'contrasena_hash' => bcrypt('secret123'),
            'telefono' => '222222222',
            'rol_id' => 2,
            'activo' => true,
        ]);

        $dueno = Usuario::create([
            'nombre' => 'Dueño Uno',
            'correo' => 'dueno1@example.com',
            'contrasena_hash' => bcrypt('secret123'),
            'telefono' => '333333333',
            'rol_id' => 4,
            'activo' => true,
        ]);

        $otherOwner = Usuario::create([
            'nombre' => 'Dueño Dos',
            'correo' => 'dueno2@example.com',
            'contrasena_hash' => bcrypt('secret123'),
            'telefono' => '444444444',
            'rol_id' => 4,
            'activo' => true,
        ]);

        $petVisible = Mascota::create([
            'dueno_id' => $dueno->id,
            'nombre' => 'Luna',
            'especie' => 'Perro',
            'raza' => 'Labrador',
            'fecha_nacimiento' => '2020-01-01',
            'sexo' => 'Hembra',
            'peso' => 12.5,
            'estado_salud' => 'al_dia',
            'activa' => true,
        ]);

        $petHidden = Mascota::create([
            'dueno_id' => $otherOwner->id,
            'nombre' => 'Max',
            'especie' => 'Gato',
            'raza' => 'Siamés',
            'fecha_nacimiento' => '2019-01-01',
            'sexo' => 'Macho',
            'peso' => 5.2,
            'estado_salud' => 'al_dia',
            'activa' => true,
        ]);

        Cita::create([
            'mascota_id' => $petVisible->id,
            'veterinario_id' => $vet->id,
            'agendada_por' => $dueno->id,
            'fecha' => '2026-09-20',
            'hora' => '09:00:00',
            'tipo_consulta' => 'Consulta general',
            'estado' => 'agendada',
        ]);

        Cita::create([
            'mascota_id' => $petHidden->id,
            'veterinario_id' => $otherVet->id,
            'agendada_por' => $otherOwner->id,
            'fecha' => '2026-09-21',
            'hora' => '10:00:00',
            'tipo_consulta' => 'Consulta general',
            'estado' => 'agendada',
        ]);

        $this->actingAs($vet)
            ->get('/historial/listar')
            ->assertOk()
            ->assertSee('Luna')
            ->assertDontSee('Max');

        $this->actingAs($vet)
            ->get('/historial/verHistorial/'.$petHidden->id)
            ->assertStatus(403);

        $this->actingAs($vet)
            ->get('/vacuna/listar')
            ->assertOk()
            ->assertSee('Luna')
            ->assertDontSee('Max');

        $this->actingAs($vet)
            ->get('/vacuna/verVacunas/'.$petHidden->id)
            ->assertStatus(403);
    }
}
