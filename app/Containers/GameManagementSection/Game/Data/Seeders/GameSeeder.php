<?php

namespace App\Containers\GameManagementSection\Game\Data\Seeders;

use App\Containers\GameManagementSection\Game\Enums\GameGenre;
use App\Containers\GameManagementSection\Game\Models\Game;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Seeders\Seeder;


class GameSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('login', 'test')->first();

        Game
            ::factory()
            ->count(12)
            ->hasAttached($user)
            ->create(
            [
                'name' => $this->faker->word(),
                'genre' => GameGenre::RPG
            ]
        );
    }
}
