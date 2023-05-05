<?php

namespace App\Ship\Parents\Factories;

use App\Ship\Parents\Models\Permission;

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->slug,
        ];
    }
}
