<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\{PermissionTableSeeder as SeedersPermissionTableSeeder, UserTableSeeder as SeedersUserTableSeeder};
use Illuminate\Database\Seeder;
use lluminate\Database\Seeder\PermissionTableSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CustomerTableSeeder::class,
            SeedersUserTableSeeder::class,
        ]);
    }
}
