<?php

namespace Database\Seeders;

use App\Models\{Permission, Role, User};
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        // Definindo permissões
        $permissions = [
            'view customers',
            'create customers',
            'update customers',
            'delete customers',
            'assign_access_customer',
            'revoke_access_customer',
            'revoke_all_access_customer',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Definindo roles e associando permissões
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($permissions);

        $regularRole = Role::firstOrCreate(['name' => 'regular']);
        $regularRole->syncPermissions(['view customers']);

        $restrictedRole = Role::firstOrCreate(['name' => 'restricted']);
        $restrictedRole->syncPermissions([]);

        // Criando usuário admin
        $admin = User::updateOrCreate(
            ['email' => 'gierdiaz@admin'],
            [
                'name'     => 'Állison',
                'password' => bcrypt('password'),
            ]
        );

        $token = $admin->createToken('TokenName')->plainTextToken;

        echo 'Token: ' . $token . PHP_EOL;

        $admin->assignRole($adminRole);

        // Criando usuário regular
        $regularUser = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name'     => 'Regular User',
                'password' => bcrypt('password'),
            ]
        );
        $regularUser->assignRole($regularRole);
    }
}
