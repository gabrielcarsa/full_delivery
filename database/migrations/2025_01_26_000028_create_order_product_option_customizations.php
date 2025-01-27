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
        Schema::create('order_product_option_customizations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_product_option_id');
            $table->foreign('order_product_option_id', 'order_product_option_fk')->references('id')->on('order_product_options')->onDelete('cascade');
            $table->unsignedBigInteger('product_option_customization_id');
            $table->foreign('product_option_customization_id', 'prod_opt_cust_fk')->references('id')->on('product_option_customizations')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps(); // created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product_option_customizations');
    }
};
