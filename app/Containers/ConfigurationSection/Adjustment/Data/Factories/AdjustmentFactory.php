<?php

namespace App\Containers\ConfigurationSection\Adjustment\Data\Factories;

use App\Containers\ConfigurationSection\Adjustment\Models\Adjustment;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Parents\Models\User;
use Illuminate\Support\Facades\File;

/**
 * @method Adjustment createOne($data = [])
 */
class AdjustmentFactory extends Factory
{
    protected $model = Layout::class;

    public function definition(): array
    {
        $file = File::get(__DIR__ . '/../Stubs/Adjustment.json');

        return [
            'name' => $this->faker->word,
            'priority' => $this->faker->numberBetween(1, 100),
            'setting_id' => Setting::factory(),
            'author_id' => User::factory(),
            'schema' => json_encode(json_decode($file)),
        ];
    }
}
