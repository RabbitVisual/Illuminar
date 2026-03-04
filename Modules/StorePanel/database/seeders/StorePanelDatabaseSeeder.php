<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\StorePanel\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class StorePanelDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuário demo para o PDV (StorePanel)
        $user = User::firstOrCreate(
            ['email' => 'pdv-demo@illuminar.com.br'],
            [
                'first_name' => 'Caixa',
                'last_name' => 'PDV Demo',
                'email' => 'pdv-demo@illuminar.com.br',
                'password' => bcrypt('password'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        if (! $user->hasRole('Cashier')) {
            $user->assignRole('Cashier');
        }

        $user->update(['email_verified_at' => now()]);
    }
}
