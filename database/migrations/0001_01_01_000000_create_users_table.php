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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Dados pessoais
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 20)->nullable();
            $table->string('phone_secondary', 20)->nullable();
            $table->string('photo')->nullable();
            $table->date('birth_date')->nullable();

            // Documentos (CPF/CNPJ para e-commerce B2B/B2C)
            $table->enum('document_type', ['cpf', 'cnpj'])->default('cpf');
            $table->string('document', 18)->unique()->nullable();
            $table->string('company_name')->nullable();
            $table->string('trade_name')->nullable();
            $table->string('state_registration', 20)->nullable();
            $table->string('municipal_registration', 20)->nullable();

            // Endereço principal
            $table->string('postal_code', 10)->nullable();
            $table->string('street')->nullable();
            $table->string('number', 20)->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('state', 2)->nullable();
            $table->string('country', 2)->default('BR');

            // Perfil e permissões
            $table->enum('role', ['admin', 'manager', 'sales', 'customer', 'supplier'])->default('customer');
            $table->enum('status', ['active', 'blocked', 'inactive', 'pending_verification'])->default('active');
            $table->json('permissions')->nullable();

            // Preferências e marketing
            $table->boolean('newsletter')->default(false);
            $table->boolean('accepts_marketing')->default(false);
            $table->string('preferred_contact', 20)->default('email'); // email, phone, whatsapp

            // Verificação e segurança
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->rememberToken();

            // Auditoria e logs
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'role']);
            $table->index('document_type');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index()->constrained()->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
