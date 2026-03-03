<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('type', 30); // correios, motoboy, pickup
            $table->unsignedInteger('base_price'); // centavos - NUNCA gratuito por padrão
            $table->unsignedInteger('delivery_time_days')->default(1);
            $table->boolean('is_active')->default(true);
            $table->string('coverage_type', 30)->default('national'); // national, state, cities, zip_codes
            $table->json('coverage_data')->nullable(); // lista de cidades, estados ou faixas de CEP
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_methods');
    }
};
