<?php

namespace App\Ship\Parents\Factories;

abstract class UserRoleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->slug,
        ];
    }
}
