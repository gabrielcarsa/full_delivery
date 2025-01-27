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
        Schema::create('order_deliveries', function (Blueprint $table) {
            $table->id();
            $table->float('distance_meters');
            $table->integer('time_min'); // Tempo mínimo de entrega, em minutos
            $table->integer('time_max'); // Tempo máximo de entrega, em minutos
            $table->decimal('delivery_fee', 10, 2); // Taxa de entrega
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('postal_code', 50);
            $table->string('neighborhood', 100);
            $table->string('street', 50);
            $table->string('number', 20);
            $table->string('complement', 255)->nullable();
            $table->string('city', 100);
            $table->string('state', 100);
            $table->string('country', 100);
            $table->timestamp('delivery_date');
            $table->timestamps(); // created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_deliveries');
    }
};
