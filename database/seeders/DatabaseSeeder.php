<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Sempre atualiza ou insere - nunca limpa dados existentes.
     */
    public function run(): void
    {
        $this->seedMasterAdmin();
    }

    /**
     * Master Admin do sistema - sempre atualizado ou criado.
     */
    private function seedMasterAdmin(): void
    {
        $masterData = [
            'first_name' => 'Reinan',
            'last_name' => 'Admin',
            'email' => 'reinan@vertexsolutions.com',
            'password' => Hash::make('32579345'),
            'role' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
            'document_type' => 'cpf',
            'document' => null,
            'company_name' => 'Vertex Solutions',
            'phone' => null,
            'phone_secondary' => null,
            'photo' => null,
            'birth_date' => null,
            'trade_name' => null,
            'state_registration' => null,
            'municipal_registration' => null,
            'postal_code' => null,
            'street' => null,
            'number' => null,
            'complement' => null,
            'neighborhood' => null,
            'city' => null,
            'state' => null,
            'country' => 'BR',
            'permissions' => null,
            'newsletter' => false,
            'accepts_marketing' => false,
            'preferred_contact' => 'email',
        ];

        User::updateOrCreate(
            ['email' => 'reinan@vertexsolutions.com'],
            $masterData
        );
    }
}
