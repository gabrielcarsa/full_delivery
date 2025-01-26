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
        Schema::create('store_tables', function (Blueprint $table) {
            $table->id();
            $table->string('name', 10); // Número ou nome da mesa
            $table->boolean('is_occupied')->default(false); // Indica se a mesa está ocupada
            $table->timestamp('opening_time')->nullable(); // Hora de abertura da mesa
            $table->boolean('is_active')->default(true); // Indica se a mesa está ativa
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade'); // Relacionamento com a tabela stores
            $table->timestamps(); // created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_tables');
    }
};
