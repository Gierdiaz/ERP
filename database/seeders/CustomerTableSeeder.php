<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    public function run(): void
    {
        Customer::factory()->count(1)->create();
    }
}
