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
        Schema::create('store_delivery', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('store')->onDelete('cascade'); // Relacionamento com a tabela store
            $table->boolean('is_free_delivery')->default(false); // Para indicar se a entrega é gratuita
            $table->decimal('delivery_fee_per_km', 10, 2)->nullable(); // Taxa de entrega por km
            $table->decimal('delivery_fee', 10, 2)->nullable(); // Taxa fixa de entrega
            $table->float('delivery_area_meters')->nullable(); // Área de entrega em metros
            $table->timestamps(); // Criação dos campos 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_delivery');
    }
};
