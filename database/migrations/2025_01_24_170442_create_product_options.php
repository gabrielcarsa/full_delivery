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
        Schema::create('product_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_option_category_id')->constrained('product_option_categories')->onDelete('cascade'); // Chave estrangeira para product_options_category
            $table->string('name', 100); // Nome da opção do produto
            $table->string('description', 100)->nullable(); // Descrição da opção do produto
            $table->decimal('price', 10, 2); // Preço da opção
            $table->decimal('price_discount', 10, 2)->nullable(); // Preço com desconto da opção
            $table->timestamps(); // Campos 'created_at' e 'updated_at'
            $table->foreignId('created_by_user_id')->constrained('users')->onDelete('cascade'); // Criado por
            $table->foreignId('updated_by_user_id')->constrained('users')->onDelete('cascade'); // Atualizado por
            $table->string('externalCodeIfood', 100)->nullable(); // Código externo da opção no iFood
            $table->string('productIdIfood', 100)->nullable(); // ID do produto no iFood
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_options');
    }
};
