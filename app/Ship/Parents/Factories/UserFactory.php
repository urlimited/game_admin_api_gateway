<?php

namespace App\Ship\Parents\Factories;

use App\Ship\Parents\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * @method User createOne($attributes = [])
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'login' => $this->faker->name,
            'password' => Hash::make('secret'),
        ];
    }
}
