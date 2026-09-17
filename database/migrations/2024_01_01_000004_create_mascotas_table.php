<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dueno_id')->constrained('usuarios')->restrictOnDelete();
            $table->string('nombre', 100);
            $table->string('especie', 50);
            $table->string('raza', 80);
            $table->date('fecha_nacimiento');
            $table->enum('sexo', ['Macho', 'Hembra']);
            $table->decimal('peso', 6, 2);
            $table->enum('estado_salud', ['al_dia', 'pendiente_atencion'])->default('al_dia');
            $table->boolean('activa')->default(true);
            $table->timestamps();

            $table->index('dueno_id', 'idx_mascota_dueno');
            $table->index('activa', 'idx_mascota_activa');
            $table->index(['nombre', 'especie'], 'idx_mascota_busqueda');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
