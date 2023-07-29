<?php

namespace App\Containers\AnalyticsSection\StatEvent\Data\Factories;

use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Containers\AnalyticsSection\StatEvent\Enums\StatEventType;
use App\Containers\AnalyticsSection\StatEvent\Models\StatEvent;
use App\Ship\Parents\Factories\Factory;

/**
 * @method Game createOne($data = [])
 */
class StatEventFactory extends Factory
{
    protected $model = StatEvent::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'type' => StatEventType::Quantitative->value,
            'game_id' => Game::factory(),
        ];
    }
}
