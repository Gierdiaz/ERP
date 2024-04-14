<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Permission, Role};

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'manage customers']);
        Permission::create(['name' => 'view customers']);
        Permission::create(['name' => 'create customers']);
        Permission::create(['name' => 'update customers']);
        Permission::create(['name' => 'delete customers']);

        // Criar papéis e atribuir permissões
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(['view customers', 'create customers', 'update customers', 'delete customers', 'manage customers']);

        $regularRole = Role::create(['name' => 'regular']);
        $regularRole->givePermissionTo('view customers', 'create customers');

        // Criar usuários e atribuir papéis
        $adminUser = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $adminUser->assignRole($adminRole);

        $regularUser = User::create([
            'name'     => 'Regular User',
            'email'    => 'user@example.com',
            'password' => bcrypt('password'),
        ]);
        $regularUser->assignRole($regularRole);
    }
}
