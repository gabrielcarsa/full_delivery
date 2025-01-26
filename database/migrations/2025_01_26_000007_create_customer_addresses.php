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
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade'); // Chave estrangeira para clientes
            $table->string('address_name', 50); // Nome do endereço (ex: "Casa", "Trabalho")
            $table->string('street', 100); // Rua
            $table->string('neighborhood', 100); // Bairro
            $table->string('number', 20)->nullable(); // Número (opcional)
            $table->string('complement', 100)->nullable(); // Complemento (opcional)
            $table->string('city', 100); // Cidade
            $table->string('state', 100); // Estado
            $table->string('country', 100)->default('Brasil'); // País (default: Brasil)
            $table->string('zip_code', 20); // CEP
            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};
