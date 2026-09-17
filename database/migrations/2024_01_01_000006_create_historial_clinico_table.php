<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historial_clinico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mascota_id')->constrained('mascotas')->restrictOnDelete();
            $table->foreignId('cita_id')->nullable()
                ->constrained('citas')->nullOnDelete();
            $table->foreignId('veterinario_id')->constrained('usuarios')->restrictOnDelete();
            $table->enum('tipo_consulta', [
                'Consulta general', 'Control', 'Urgencia', 'Cirugía', 'Vacunación', 'Desparasitación',
            ])->default('Consulta general');
            $table->string('motivo_consulta', 255);
            $table->text('diagnostico');
            $table->text('tratamiento');
            $table->text('observaciones')->nullable();
            $table->dateTime('fecha_registro')->useCurrent();
            $table->dateTime('fecha_ultima_edicion')->nullable();
            $table->foreignId('editado_por')->nullable()
                ->constrained('usuarios')->nullOnDelete();

            $table->index(['mascota_id', 'fecha_registro'], 'idx_historial_mascota');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_clinico');
    }
};
