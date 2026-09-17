<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vacunas_desparasitaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mascota_id')->constrained('mascotas')->restrictOnDelete();
            $table->foreignId('historial_id')->nullable()
                ->constrained('historial_clinico')->nullOnDelete();
            $table->foreignId('veterinario_id')->constrained('usuarios')->restrictOnDelete();
            $table->enum('tipo', ['vacuna', 'desparasitacion']);
            $table->string('nombre_producto', 120);
            $table->string('lote', 60);
            $table->date('fecha_aplicacion');
            $table->date('fecha_proxima_dosis');
            $table->boolean('aplicada_siguiente')->default(false);
            $table->dateTime('created_at')->useCurrent();

            $table->index('fecha_proxima_dosis', 'idx_vacuna_proxima_dosis');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vacunas_desparasitaciones');
    }
};
