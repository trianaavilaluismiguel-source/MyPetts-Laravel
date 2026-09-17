<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->enum('tipo', [
                'recordatorio_cita', 'recordatorio_vacuna', 'alerta_vacuna_vencida', 'otro',
            ]);
            $table->enum('referencia_tipo', ['cita', 'vacuna'])->nullable();
            $table->unsignedBigInteger('referencia_id')->nullable();
            $table->string('mensaje', 255);
            $table->enum('estado', ['enviado', 'fallido']);
            $table->boolean('mostrada_en_login')->default(false);
            $table->dateTime('fecha_envio')->useCurrent();

            $table->index(['usuario_id', 'estado'], 'idx_notificacion_usuario');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
