<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->string('barcode')->unique()->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('price'); // centavos
            $table->unsignedInteger('cost_price')->default(0); // centavos
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->string('voltage', 20)->nullable(); // Bivolt, 110V, 220V, 12V
            $table->decimal('power_watts', 10, 2)->nullable();
            $table->unsignedInteger('color_temperature_k')->nullable(); // 3000, 4000, 6000
            $table->unsignedInteger('lumens')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
