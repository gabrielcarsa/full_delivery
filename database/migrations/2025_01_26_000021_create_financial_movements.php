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
        Schema::create('financial_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checking_account_id')->constrained('checking_accounts')->onDelete('cascade');
            $table->foreignId('financial_transaction_installment_id')->constrained('financial_transaction_installments')->onDelete('cascade');
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->boolean('type'); // Tipo do movimento (0 = saída, 1 = entrada)
            $table->decimal('amount', 10, 2); // Valor do movimento
            $table->date('movement_date'); // Data do movimento
            $table->timestamps(); // created_at e updated_at
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_movements');
    }
};
