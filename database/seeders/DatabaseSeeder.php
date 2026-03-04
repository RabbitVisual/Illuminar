<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Sempre atualiza ou insere - nunca limpa dados existentes.
     */
    public function run(): void
    {
        $this->call(\Modules\User\Database\Seeders\RolesAndPermissionsSeeder::class);
        $this->seedMasterAdmin();
        $this->call(\Modules\Payment\Database\Seeders\PaymentDatabaseSeeder::class);
        $this->call(\Modules\Shipping\Database\Seeders\ShippingDatabaseSeeder::class);
        $this->call(\Modules\Core\Database\Seeders\CoreDatabaseSeeder::class);
        $this->call(\Modules\Catalog\Database\Seeders\CatalogDatabaseSeeder::class);
        $this->call(\Modules\Inventory\Database\Seeders\InventoryDatabaseSeeder::class);
        $this->call(\Modules\Sales\Database\Seeders\SalesDatabaseSeeder::class);
        $this->call(\Modules\Storefront\Database\Seeders\StorefrontDatabaseSeeder::class);
        $this->call(\Modules\Admin\Database\Seeders\AdminDatabaseSeeder::class);
        $this->call(\Modules\CustomerPanel\Database\Seeders\CustomerPanelDatabaseSeeder::class);
        $this->call(\Modules\StorePanel\Database\Seeders\StorePanelDatabaseSeeder::class);
        $this->call(\Modules\Notification\Database\Seeders\NotificationDatabaseSeeder::class);
        $this->call(\Modules\Notification\Database\Seeders\NotificationTemplateSeeder::class);
        $this->call(\Modules\Document\Database\Seeders\DocumentDatabaseSeeder::class);
        $this->seedDemoCustomer();
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

        $reinan = User::updateOrCreate(
            ['email' => 'reinan@vertexsolutions.com'],
            $masterData
        );

        $superAdminRole = Role::where('name', 'SuperAdmin')->where('guard_name', 'web')->first();
        if ($superAdminRole && ! $reinan->hasRole('SuperAdmin')) {
            $reinan->assignRole('SuperAdmin');
        }
    }

    /**
     * Usuário cliente demo para testes de compra no storefront.
     */
    private function seedDemoCustomer(): void
    {
        $customerData = [
            'first_name' => 'Cliente',
            'last_name' => 'Demo',
            'email' => 'cliente@demo.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
        ];

        $customer = User::updateOrCreate(
            ['email' => 'cliente@demo.com'],
            $customerData
        );

        $customerRole = Role::where('name', 'Customer')->where('guard_name', 'web')->first();
        if ($customerRole && ! $customer->hasRole('Customer')) {
            $customer->assignRole('Customer');
        }
    }
}
