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
        Schema::create('checking_account_balances', function (Blueprint $table) {
            $table->id();
            $table->decimal('balance', 10, 2); // Saldo da conta corrente
            $table->foreignId('checking_account_id')->constrained('checking_accounts')->onDelete('cascade');
            $table->date('balance_date'); // Data do saldo
            $table->timestamps(); // created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checking_account_balances');
    }
};
