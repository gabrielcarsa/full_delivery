<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('store_opening_hours', function (Blueprint $table) {
            $table->id();
            $table->string('day_of_week', 50); // Dia da semana (em inglês)
            $table->time('opening_time'); // Hora de abertura
            $table->time('closing_time'); // Hora de fechamento
            $table->timestamps(); // Campos 'created_at' e 'updated_at'

            // Chaves estrangeiras e relacionamentos
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade'); // Referência à tabela 'store'
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->onDelete('cascade'); // Criado por
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->onDelete('cascade'); // Atualizado por
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_opening_hours');
    }
};
