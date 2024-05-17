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

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $role = Role::firstOrCreate(['name' => 'admin']);
        $role->syncPermissions($permissions);

        $regular = Role::firstOrCreate(['name' => 'regular']);
        $regular->syncPermissions([
            'view customers',
        ]);

        $restricted = Role::firstOrCreate(['name' => 'restricted']);
        $restricted->syncPermissions([]);

        $admin = User::firstOrCreate([
            'name'     => 'Állison',
            'email'    => 'gierdiaz@admin',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole($role);

        $regular = User::create([
            'name'     => 'Regular User',
            'email'    => 'user@example.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        $regular->givePermissionTo('view customers');
    }
}
