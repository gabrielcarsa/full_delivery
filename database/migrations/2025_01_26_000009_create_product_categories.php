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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // Nome da categoria
            $table->string('description', 500)->nullable(); // Descrição da categoria
            $table->integer('order'); // Ordem de exibição
            $table->timestamps(); // Campos 'created_at' e 'updated_at'
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->onDelete('cascade'); // Criado por
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->onDelete('cascade'); // Atualizado por
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade'); // Loja associada à categoria
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
