<?php

namespace App\Containers\ConfigurationSection\Setting\Data\Factories;

use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Parents\Models\User;
use Illuminate\Support\Facades\File;

/**
 * @method Setting  createOne($data = [])
 *
 */
class SettingFactory extends Factory
{
    protected $model = Setting::class;

    public function definition(): array
    {
        $file = File::get(__DIR__ . '/../Stubs/Setting.json');

        return [
            'name' => $this->faker->word,
            'layout_id' => null,
            'schema' => json_encode(json_decode($file)),
            'author_id' => User::factory(),
            'game_id' => Game::factory(),
        ];
    }
}
