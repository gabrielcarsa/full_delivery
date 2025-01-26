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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('status');
            $table->string('type', 50);
            $table->string('observations', 200)->nullable();
            $table->string('cancellation_rejection_message', 200)->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->boolean('is_simulation')->default(false);
            $table->string('client_name', 100);
            $table->boolean('via_ifood')->default(false);
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->foreignId('store_table_id')->nullable()->constrained('store_tables')->onDelete('set null');
            $table->foreignId('financial_transaction_id')->nullable()->constrained('financial_transactions')->onDelete('set null');
            $table->timestamps(); // created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
