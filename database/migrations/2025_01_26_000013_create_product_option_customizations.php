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
        Schema::create('product_option_customizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_option_id')->constrained('product_options')->onDelete('cascade'); // Chave estrangeira para product_options
            $table->string('name', 100); // Nome da customização da opção
            $table->string('description', 100)->nullable(); // Descrição da customização
            $table->decimal('price', 10, 2); // Preço da customização
            $table->decimal('price_discount', 10, 2)->nullable(); // Preço com desconto da customização
            $table->timestamps(); // Campos 'created_at' e 'updated_at'
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->onDelete('cascade'); // Criado por
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->onDelete('cascade'); // Atualizado por
            $table->string('externalCodeIfood', 100)->nullable(); // Código externo da customização no iFood
            $table->string('productIdIfood', 100)->nullable(); // ID do produto no iFood
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_option_customizations');
    }
};
