<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mascota_id')->constrained('mascotas')->restrictOnDelete();
            $table->foreignId('veterinario_id')->constrained('usuarios')->restrictOnDelete();
            $table->foreignId('agendada_por')->constrained('usuarios')->restrictOnDelete();
            $table->date('fecha');
            $table->time('hora');
            $table->string('tipo_consulta', 100);
            $table->enum('estado', ['agendada', 'cancelada', 'reagendada', 'completada'])
                ->default('agendada');
            $table->foreignId('cita_origen_id')->nullable()
                ->constrained('citas')->nullOnDelete();
            $table->string('motivo_cancelacion', 255)->nullable();
            $table->timestamps();

            $table->unique(['veterinario_id', 'fecha', 'hora'], 'uq_cita_horario');
            $table->index(['fecha', 'hora'], 'idx_cita_fecha');
            $table->index('estado', 'idx_cita_estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
