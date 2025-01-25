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
            $table->string('code', 50)->unique(); // Código do cupom (único)
            $table->string('type'); // Tipo de cupom
            $table->decimal('discount_value', 10, 2); // Valor do desconto (pode ser percentual ou valor fixo)
            $table->decimal('minimum_order_value', 10, 2); // Valor mínimo do pedido para o cupom ser aplicado
            $table->date('valid_from'); // Data de início de validade
            $table->date('valid_until'); // Data de fim de validade
            $table->boolean('is_active'); // Se o cupom está ativo
            $table->timestamps(); // Campos created_at e updated_at

            // Chaves estrangeiras
            $table->foreignId('created_by_user_id')->constrained('users')->onDelete('cascade'); // Criado por usuário
            $table->foreignId('updated_by_user_id')->constrained('users')->onDelete('cascade'); // Atualizado por usuário
            $table->foreignId('store_id')->constrained('store')->onDelete('cascade'); // Relacionamento com a tabela store
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
