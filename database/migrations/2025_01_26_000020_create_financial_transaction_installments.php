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
        Schema::create('financial_transaction_installments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('financial_transaction_id');
            $table->foreign('financial_transaction_id', 'financial_transaction_fk')->references('id')->on('financial_transactions')->onDelete('cascade');
            $table->integer('installment_number'); // Número da parcela
            $table->decimal('amount', 10, 2); // Valor da parcela
            $table->date('due_date'); // Data de vencimento da parcela
            $table->timestamp('payment_date')->nullable(); // Data do pagamento (opcional)
            $table->integer('status'); // Status da parcela (0 = não paga, 1 = paga)
            $table->decimal('paid_amount', 10, 2)->nullable(); // Valor pago (opcional)
            $table->timestamp('settlement_date')->nullable(); // Data de liquidação (opcional)
            $table->timestamps(); // created_at e updated_at
            $table->foreignId('created_by_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by_user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('marked_down_by_user_id')->nullable();
            $table->foreign('marked_down_by_user_id', 'marked_user_fk')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_transaction_installments');
    }
};
