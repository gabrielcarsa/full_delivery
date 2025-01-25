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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('cnpj', 14)->nullable();
            $table->string('cpf', 11)->nullable();
            $table->string('email', 100);
            $table->string('type', 100);
            $table->string('description', 200)->nullable();
            $table->string('monthly_billing', 100)->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('street', 100)->nullable();
            $table->string('neighborhood', 100)->nullable();
            $table->string('number', 20)->nullable();
            $table->string('complement', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('zip_code', 20)->nullable();
            $table->string('phone1', 11)->nullable();
            $table->string('phone2', 11)->nullable();
            $table->string('status', 50);
            $table->string('ifood_merchant_id', 255)->nullable();
            $table->decimal('service_fee', 10, 2);
            $table->timestamps();
            $table->foreignId('created_by_user_id')->constrained('users');
            $table->foreignId('updated_by_user_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store');
    }
};
