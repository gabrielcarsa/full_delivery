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
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_customer_default')->default(false); // Cliente padrão ou não
            $table->foreignId('store_id')->constrained('store')->onDelete('cascade'); // Relacionamento com store
            $table->string('name', 100); // Nome
            $table->string('cpf', 11)->nullable(); // CPF (opcional)
            $table->string('phone', 50); // Telefone
            $table->string('email', 100)->unique()->nullable(); // Email (opcional, mas único)
            $table->string('password', 255); // Senha
            $table->string('street', 100)->nullable(); // Rua
            $table->string('neighborhood', 100)->nullable(); // Bairro
            $table->string('number', 20)->nullable(); // Número
            $table->string('complement', 100)->nullable(); // Complemento
            $table->string('city', 100)->nullable(); // Cidade
            $table->string('state', 100)->nullable(); // Estado
            $table->string('country', 100)->nullable(); // País
            $table->string('zip_code', 20)->nullable(); // CEP
            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client');
    }
};
