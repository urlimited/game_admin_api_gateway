<?php

namespace App\Ship\Parents\Factories;

use App\Ship\Parents\Models\Role;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->slug,
        ];
    }
}
