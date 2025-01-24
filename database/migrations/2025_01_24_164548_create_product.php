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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')->constrained('product_category')->onDelete('cascade'); // Chave estrangeira para product_category
            $table->string('name', 100); // Nome do produto
            $table->string('description', 500)->nullable(); // Descrição do produto
            $table->string('image', 255)->nullable(); // Imagem do produto
            $table->integer('serving')->nullable(); // Porção
            $table->decimal('price', 10, 2); // Preço normal
            $table->decimal('price_discount', 10, 2)->nullable(); // Preço com desconto
            $table->boolean('available')->default(true); // Disponibilidade
            $table->boolean('highlight')->default(false); // Produto em destaque
            $table->integer('minimum_preparation_time')->nullable(); // Tempo mínimo de preparo
            $table->integer('maximum_preparation_time')->nullable(); // Tempo máximo de preparo
            $table->foreignId('created_by_user_id')->constrained('users')->onDelete('cascade'); // Criado por
            $table->foreignId('updated_by_user_id')->constrained('users')->onDelete('cascade'); // Atualizado por
            $table->string('external_code_ifood', 100)->nullable(); // Código externo do iFood
            $table->string('product_id_ifood', 100)->nullable(); // ID do produto no iFood
            $table->string('image_ifood', 400)->nullable(); // Imagem do produto no iFood
            $table->timestamps(); // Campos 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
