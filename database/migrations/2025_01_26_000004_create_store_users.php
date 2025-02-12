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
        Schema::create('store_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Chave estrangeira para users
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade'); // Chave estrangeira para store
            $table->string('access_level', 50); // Nível de acesso
            $table->string('position', 100); // Posição do usuário na loja
            $table->boolean('is_active')->default(false);
            $table->timestamps(); // Campos 'created_at' e 'updated_at'
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->onDelete('cascade'); // Chave estrangeira para 'created_by'
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->onDelete('cascade'); // Chave estrangeira para 'updated_by'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_users');
    }
};