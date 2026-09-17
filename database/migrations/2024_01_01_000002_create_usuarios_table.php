<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120);
            $table->string('correo', 150)->unique();
            $table->string('contrasena_hash', 255);
            $table->string('telefono', 20);
            $table->foreignId('rol_id')->constrained('roles')->restrictOnDelete();
            $table->boolean('activo')->default(true);
            $table->tinyInteger('intentos_fallidos')->default(0);
            $table->dateTime('bloqueado_hasta')->nullable();
            $table->boolean('requiere_cambio_pwd')->default(false);
            $table->foreignId('creado_por')->nullable()
                ->constrained('usuarios')->nullOnDelete();
            $table->timestamps();

            $table->index('rol_id', 'idx_usuarios_rol');
            $table->index('activo', 'idx_usuarios_activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
