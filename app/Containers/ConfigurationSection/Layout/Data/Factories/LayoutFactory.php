<?php

namespace App\Containers\ConfigurationSection\Layout\Data\Factories;

use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Ship\Parents\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @method Game createOne($data = [])
 */
class LayoutFactory extends Factory
{
    protected $model = Layout::class;

    public function definition(): array
    {
        $file = File::get(__DIR__ . '/../Stubs/DefaultLayoutStub.json');

        return [
            'name' => $this->faker->word,
            'game_id' => Game::factory(),
            'schema' => json_encode(json_decode($file)),
            'version'=>'13.25.42'
        ];
    }
}
