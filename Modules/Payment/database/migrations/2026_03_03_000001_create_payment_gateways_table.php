<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('provider', 50); // mercadopago, pagarme, stripe
            $table->text('credentials')->nullable(); // encrypted: public_key, secret_key, webhook_url, etc.
            $table->string('environment', 20)->default('sandbox'); // sandbox, production
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->unique(['provider', 'environment']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
