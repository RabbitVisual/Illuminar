<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\CustomerPanel\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CustomerPanelDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cliente demo para o painel do cliente
        $customer = User::firstOrCreate(
            ['email' => 'cliente-demo@illuminar.com.br'],
            [
                'first_name' => 'Cliente',
                'last_name' => 'Demo',
                'email' => 'cliente-demo@illuminar.com.br',
                'password' => bcrypt('password'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        if (! $customer->hasRole('Customer')) {
            $customer->assignRole('Customer');
        }

        $customer->update(['email_verified_at' => now()]);
    }
}
