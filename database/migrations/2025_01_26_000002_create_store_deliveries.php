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
        Schema::create('store_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->boolean('is_free_delivery')->nullable();
            $table->decimal('delivery_fee_per_km', 10, 2)->nullable();
            $table->decimal('delivery_fee', 10, 2)->nullable();
            $table->float('delivery_area_meters')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_deliveries');
    }
};
