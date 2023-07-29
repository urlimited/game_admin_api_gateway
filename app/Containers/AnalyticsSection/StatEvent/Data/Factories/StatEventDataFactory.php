<?php

namespace App\Containers\AnalyticsSection\StatEvent\Data\Factories;

use App\Containers\AnalyticsSection\Player\Models\Player;
use App\Containers\AnalyticsSection\StatEvent\Models\StatEvent;
use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Ship\Parents\Factories\Factory;

/**
 * @method Game createOne($data = [])
 */
class StatEventDataFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        return [
            'player_id' => Player::factory(),
            'stat_event_id' => StatEvent::factory(),
            'value' => $this->faker->numberBetween(0,100),
        ];
    }
}
