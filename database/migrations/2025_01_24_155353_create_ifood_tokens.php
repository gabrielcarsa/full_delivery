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
        Schema::create('ifood_tokens', function (Blueprint $table) {
            $table->id();
            $table->text('access_token');
            $table->timestamp('expires_at')->nullable(); // A data de expiração do token
            $table->text('refresh_token')->nullable(); // O token de refresh
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade'); // Chave estrangeira para a tabela store
            $table->timestamps(); // Criação dos campos 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ifood_tokens');
    }
};
