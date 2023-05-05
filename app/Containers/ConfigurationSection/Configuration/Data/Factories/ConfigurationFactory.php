<?php

namespace App\Containers\ConfigurationSection\Configuration\Data\Factories;

use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Parents\Models\User;
use Illuminate\Support\Facades\File;

/**
 * @method Structure  createOne($data = [])
 *
 */
class ConfigurationFactory extends Factory
{
    protected $model = Configuration::class;

    public function definition(): array
    {
        $file = File::get(__DIR__ . '/../Stubs/congs .json');

        return [
            'name' => $this->faker->word,
            'structure_id' => null,
            'schema' => json_encode(json_decode($file)),
            'author_id' => User::factory(),
            'game_id' => Game::factory(),
        ];
    }
}
