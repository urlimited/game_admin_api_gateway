<?php

namespace App\Containers\GameManagementSection\Player\Actions;

use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\Player\Tasks\PlayerFilterTask;
use App\Containers\GameManagementSection\Player\UI\Contracts\Requests\PlayerShowRequestContract;
use App\Ship\Parents\Actions\Action;
use Prettus\Repository\Exceptions\RepositoryException;

class PlayerShowAction extends Action
{
    /**
     * @param PlayerShowRequestContract $request
     * @param Player $player
     * @return Player
     */
    public function run(PlayerShowRequestContract $request, Player $player): Player
    {
        return $player;
    }
}
