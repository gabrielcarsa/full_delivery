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
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->boolean('type'); // Tipo da transação (paga ou a receber)
            $table->string('description', 255); // Descrição da transação
            $table->decimal('installment_value', 10, 2); // Valor de cada parcela
            $table->decimal('down_payment', 10, 2); // Valor do pagamento inicial
            $table->date('due_date'); // Data de vencimento
            $table->timestamp('payment_date')->nullable(); // Data do pagamento (pode ser nula)
            $table->integer('number_of_installments'); // Número de parcelas
            $table->foreignId('financial_category_id')->constrained('financial_categories')->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->timestamps(); // created_at e updated_at
            $table->foreignId('created_by_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by_user_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
