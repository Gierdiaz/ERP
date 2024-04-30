<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Document;
use Database\Seeders\{UserTableSeeder as SeedersUserTableSeeder};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        Document::factory()->count(1)->create();

        $this->call([
            CustomerTableSeeder::class,
            SeedersUserTableSeeder::class,
            EmployeeTableSeeder::class,
        ]);
    }
}
