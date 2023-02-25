<?php

namespace App\Containers\GameManagementSection\Player\Data\Repositories;

use App\Containers\GameManagementSection\Player\Models\Player;
use App\Ship\Parents\Repositories\Repository;

/**
 * @method Player create(array $data)
 */
class PlayerRepository extends Repository
{
    protected $fieldSearchable = [
        'login' => '=',
        'game_id' => '=',
        'id' => '='
    ];

    public function model(): string
    {
        return Player::class;
    }
}
