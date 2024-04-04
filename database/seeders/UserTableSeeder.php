<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar permissões
        Permission::create(['name' => 'view customers']);
        Permission::create(['name' => 'create customers']);
        Permission::create(['name' => 'update customers']);
        Permission::create(['name' => 'delete customers']);

        // Criar papéis e atribuir permissões
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(['view customers', 'create customers', 'update customers', 'delete customers']);
        //dd($);
        $regularRole = Role::create(['name' => 'regular']);
        $regularRole->givePermissionTo('view customers', 'create customers');

        // Criar usuários e atribuir papéis
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $adminUser->assignRole($adminRole);

        $regularUser = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);
        $regularUser->assignRole($regularRole);
    }
}
