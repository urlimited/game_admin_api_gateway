<?php

namespace App\Ship\Parents\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'login' => $this->faker->name,
            'password' => Hash::make('secret'),
        ];
    }
}
