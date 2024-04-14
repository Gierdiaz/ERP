<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'             => $this->faker->name,
            'description'      => $this->faker->sentence,
            'price'            => 12.99,
            'amount_available' => 30,
        ];
    }
}
