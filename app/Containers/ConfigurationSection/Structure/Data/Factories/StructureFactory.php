<?php

namespace App\Containers\ConfigurationSection\Structure\Data\Factories;

use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Ship\Parents\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @method Game createOne($data = [])
 */
class StructureFactory extends Factory
{
    protected $model = Structure::class;

    public function definition(): array
    {
        $file = File::get(__DIR__ . '/../Stubs/DefaultStructureStub.json');


        return [
            'name' => $this->faker->word,
            'game_id' => Game::factory(),
            'fields' => json_encode(json_decode($file)),
            'version'=>'13.25.42'
        ];
    }
}
