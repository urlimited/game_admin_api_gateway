<?php

namespace App\Containers\ConfigurationSection\Setting\Data\Factories;

use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Parents\Models\User;
use Illuminate\Support\Facades\File;

/**
 * @method Layout  createOne($data = [])
 *
 */
class SettingFactory extends Factory
{
    protected $model = Setting::class;

    public function definition(): array
    {
        $file = File::get(__DIR__ . '/../Stubs/setting.json');

        return [
            'name' => $this->faker->word,
            'structure_id' => null,
            'schema' => json_encode(json_decode($file)),
            'author_id' => User::factory(),
            'game_id' => Game::factory(),
        ];
    }
}
