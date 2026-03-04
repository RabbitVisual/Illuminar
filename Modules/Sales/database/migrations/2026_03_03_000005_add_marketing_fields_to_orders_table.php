<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('coupon_id')
                ->nullable()
                ->after('origin')
                ->constrained('coupons')
                ->nullOnDelete();

            $table->string('coupon_code', 50)
                ->nullable()
                ->after('coupon_id');

            $table->unsignedInteger('discount_amount')
                ->default(0)
                ->after('coupon_code');

            $table->string('referral_code', 50)
                ->nullable()
                ->after('discount_amount');

            $table->foreignId('referrer_id')
                ->nullable()
                ->after('referral_code')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['coupon_id']);
            $table->dropForeign(['referrer_id']);
            $table->dropColumn([
                'coupon_id',
                'coupon_code',
                'discount_amount',
                'referral_code',
                'referrer_id',
            ]);
        });
    }
};

