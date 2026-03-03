<?php

namespace Modules\User\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'users.view', 'users.create', 'users.update', 'users.delete',
            'roles.view', 'roles.update',
            'products.view', 'products.create', 'products.update', 'products.delete',
            'sales.view', 'sales.create', 'sales.cancel',
            'reports.view',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(
                ['name' => $name, 'guard_name' => 'web'],
                ['name' => $name, 'guard_name' => 'web']
            );
        }

        $roles = [
            'SuperAdmin' => 'Super Administrador',
            'Owner' => 'Dono',
            'Manager' => 'Gerente',
            'Cashier' => 'Caixa',
            'Customer' => 'Cliente',
        ];

        foreach ($roles as $name => $label) {
            Role::firstOrCreate(
                ['name' => $name, 'guard_name' => 'web'],
                ['name' => $name, 'guard_name' => 'web']
            );
        }

        $superAdmin = Role::findByName('SuperAdmin', 'web');
        $superAdmin->givePermissionTo(Permission::all());

        $admin = User::firstOrCreate(
            ['email' => 'admin@illuminar.com.br'],
            [
                'first_name' => 'Admin',
                'last_name' => 'Illuminar',
                'email' => 'admin@illuminar.com.br',
                'password' => bcrypt('password'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        if (! $admin->hasRole('SuperAdmin')) {
            $admin->assignRole('SuperAdmin');
        }

        $admin->update(['email_verified_at' => now()]);
    }
}
