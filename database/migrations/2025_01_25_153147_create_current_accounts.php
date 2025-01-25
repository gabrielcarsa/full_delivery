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
        Schema::create('current_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // Nome da conta corrente
            $table->foreignId('store_id')->constrained('store')->onDelete('cascade'); // Relacionamento com a loja
            $table->string('bank', 50); // Banco
            $table->decimal('saldo_inicial', 10, 2); // Saldo inicial
            $table->string('bank_branch', 50); // Agência bancária
            $table->string('account_number', 50); // Número da conta
            $table->timestamps(); // Campos created_at e updated_at

            // Chaves estrangeiras
            $table->foreignId('created_by_user_id')->constrained('users')->onDelete('cascade'); // Criado por usuário
            $table->foreignId('updated_by_user_id')->constrained('users')->onDelete('cascade'); // Atualizado por usuário
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_accounts');
    }
};
