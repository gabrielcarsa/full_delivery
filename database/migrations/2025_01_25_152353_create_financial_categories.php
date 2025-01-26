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
        Schema::create('financial_categories', function (Blueprint $table) {
            $table->id();
            $table->boolean('type'); // Tipo da categoria (depende da lógica do sistema, pode ser receita ou despesa)
            $table->boolean('is_default')->default(false); // Se é a categoria padrão
            $table->string('name', 50); // Nome da categoria
            $table->timestamps(); // Campos created_at e updated_at

            // Chaves estrangeiras
            $table->foreignId('created_by_user_id')->constrained('users')->onDelete('cascade'); // Criado por usuário
            $table->foreignId('updated_by_user_id')->constrained('users')->onDelete('cascade'); // Atualizado por usuário
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade'); // Relacionamento com a tabela 'store'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_categories');
    }
};
