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
        Schema::create('product_option_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50); // Nome da categoria de opções
            $table->integer('limit_quantity')->nullable(); // Quantidade limite de opções
            $table->boolean('is_required')->default(false); // Se é obrigatório
            $table->timestamps(); // Campos 'created_at' e 'updated_at'
            $table->foreignId('created_by_user_id')->constrained('users')->onDelete('cascade'); // Criado por
            $table->foreignId('updated_by_user_id')->constrained('users')->onDelete('cascade'); // Atualizado por
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Chave estrangeira para produto
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_option_categories');
    }
};
