<?php

namespace App\Ship\Parents\Factories;

use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        static $password;

        return [
            'login' => $this->faker->name,
            'password' => $password ?: $password = Hash::make('secret'),
        ];
    }
}
