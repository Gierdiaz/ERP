<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'    => $this->faker->name,
            'email'   => $this->faker->unique()->safeEmail,
            'phone'   => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'user_id' => \App\Models\User::factory()->create()->id,
        ];
    }
}
