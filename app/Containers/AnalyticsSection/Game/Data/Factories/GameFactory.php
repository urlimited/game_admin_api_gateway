<?php

namespace App\Containers\AnalyticsSection\Game\Data\Factories;

use App\Containers\GameManagementSection\Game\Enums\GameGenre;
use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Ship\Parents\Factories\Factory;

/**
 * @method Game createOne($data = [])
 */
class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        return [
            'genre' => GameGenre::RPG,
            'name' => $this->faker->word
        ];
    }
}
