<?php

namespace App\Containers\GameManagementSection\Game\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;
use App\Containers\GameManagementSection\Game\Models\Game;

/**
 * @method Game create(array $data)
 */
class GameRepository extends Repository
{
    protected $fieldSearchable = [
        'genre' => '=',
        'name' => '=',
        'id' => '='
    ];

    public function model(): string
    {
        return Game::class;
    }
}
