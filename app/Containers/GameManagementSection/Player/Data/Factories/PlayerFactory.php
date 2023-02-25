<?php

namespace App\Containers\GameManagementSection\Player\Data\Factories;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Player\Models\Player;
use App\Ship\Parents\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @method Player createOne($attributes = [])
 */
class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition(): array
    {
        return [
            'login' => $this->faker->unique->word,
            'password' => Hash::make('secret'),
            'game_id' => Game::factory()
        ];
    }
}
