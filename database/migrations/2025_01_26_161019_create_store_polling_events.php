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
        Schema::create('store_polling_events', function (Blueprint $table) {
            $table->id();
            $table->string('polling_id', 200);
            $table->string('code', 20);
            $table->string('full_code', 50);
            $table->string('order_id', 200);
            $table->string('merchant_id', 200);
            $table->timestamps(); // created_at e updated_at
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->foreignId('created_by_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by_user_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_polling_events');
    }
};
