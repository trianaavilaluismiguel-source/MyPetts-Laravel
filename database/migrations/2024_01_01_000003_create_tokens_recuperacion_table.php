<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tokens_recuperacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->string('token', 255)->unique();
            $table->dateTime('expira_en');
            $table->boolean('usado')->default(false);
            $table->dateTime('created_at')->useCurrent();

            $table->index('token', 'idx_token_valor');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tokens_recuperacion');
    }
};
