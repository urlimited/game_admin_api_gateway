<?php

namespace App\Containers\ConfigurationSection\Structure\Data\Factories;

use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Ship\Parents\Factories\Factory;

/**
 * @method Game createOne($data = [])
 */
class StructureFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        return [
            'game_id' => Game::factory(),
            'name' => $this->faker->word
        ];
    }
}
