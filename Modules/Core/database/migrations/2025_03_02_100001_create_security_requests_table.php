<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('security_requests', function (Blueprint $table) {
            $table->id();
            $table->string('type', 64); // password_reset_email, password_reset_cpf, registration, etc.
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('email')->nullable();
            $table->string('cpf', 14)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('status', 32)->default('pending'); // pending, completed, expired, failed
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->index(['type', 'status']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_requests');
    }
};
