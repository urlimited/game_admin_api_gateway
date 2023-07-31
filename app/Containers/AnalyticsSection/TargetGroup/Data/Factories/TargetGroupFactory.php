<?php

namespace App\Containers\AnalyticsSection\TargetGroup\Data\Factories;

use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Containers\AnalyticsSection\TargetGroup\Models\TargetGroup;
use App\Ship\Parents\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @method Game createOne($data = [])
 */
class TargetGroupFactory extends Factory
{
    protected $model = TargetGroup::class;

    public function definition(): array
    {
        $conditions = File::get(__DIR__ . '/../Stubs/Conditions.json');

        return [
            'name' => $this->faker->word,
            'conditions' => $conditions,
            'game_id' => Game::factory(),
        ];
    }
}
