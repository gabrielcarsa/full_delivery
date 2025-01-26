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
        Schema::create('store_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique(); // Unique coupon code
            $table->string('type', 30);
            $table->string('description', 100)->nullable();
            $table->decimal('discount_value', 10, 2); // Percentage or fixed amount
            $table->decimal('minimum_order_value', 10, 2)->nullable(); // Minimum order value for coupon to be applied
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('usage_count')->default(0);
            $table->boolean('is_active')->default(true); // Whether the coupon is active or not
            $table->timestamps();
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_coupons');
    }
};
