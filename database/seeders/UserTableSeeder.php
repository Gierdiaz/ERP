<?php

namespace Database\Seeders;

use App\Models\{Permission, Role, User};
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view customers',
            'create customers',
            'update customers',
            'delete customers',
            'assign_access_customer',
            'revoke_access_customer',
            'revoke_all_access_customer',
        ];

        // Criar permissões
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Criar roles e associar permissões
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($permissions);

        $regularRole = Role::firstOrCreate(['name' => 'regular']);
        $regularRole->syncPermissions(['view customers']);

        $restrictedRole = Role::firstOrCreate(['name' => 'restricted']);
        $restrictedRole->syncPermissions([]);

        // Criar usuário admin
        $admin = User::updateOrCreate(
            ['email' => 'gierdiaz@admin'],
            [
                'name' => 'Állison',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        $admin->assignRole($adminRole);

        // Criar usuário regular
        $regularUser = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => bcrypt('password'),
                'role' => 'regular',
            ]
        );

        $regularUser->assignRole($regularRole);
    }
}
