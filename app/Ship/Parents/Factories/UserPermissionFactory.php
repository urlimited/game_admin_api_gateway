<?php

namespace App\Ship\Parents\Factories;

abstract class UserPermissionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->slug,
        ];
    }
}
