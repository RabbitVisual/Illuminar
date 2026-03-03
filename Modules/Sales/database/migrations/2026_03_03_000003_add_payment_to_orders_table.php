<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'payment_gateway_id')) {
                $table->foreignId('payment_gateway_id')
                    ->nullable()
                    ->after('payment_method')
                    ->constrained('payment_gateways')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status', 30)
                    ->nullable()
                    ->after('payment_gateway_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'payment_status')) {
                $table->dropColumn('payment_status');
            }

            if (Schema::hasColumn('orders', 'payment_gateway_id')) {
                $table->dropConstrainedForeignId('payment_gateway_id');
            }
        });
    }
};

