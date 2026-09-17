<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reportes_generados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->enum('tipo_reporte', ['citas', 'vacunas_aplicadas', 'mascotas_atendidas']);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('formato_exportacion', ['PDF', 'Excel'])->nullable();
            $table->dateTime('generado_en')->useCurrent();

            $table->index(['fecha_inicio', 'fecha_fin'], 'idx_reporte_rango');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reportes_generados');
    }
};
