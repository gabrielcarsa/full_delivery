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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_default_customer')->nullable(); // Cliente padrão ou não
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade'); // Relacionamento com store
            $table->string('name', 100); // Nome
            $table->string('cpf', 11)->nullable(); // CPF (opcional)
            $table->string('phone', 50); // Telefone
            $table->string('email', 100)->unique()->nullable(); // Email (opcional, mas único)
            $table->string('password', 255)->nullable(); // Senha
            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
