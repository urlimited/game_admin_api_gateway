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
     * @return Player
     * @throws RepositoryException
     */
    public function run(PlayerShowRequestContract $request): Player
    {
        $gameId = $request->getGameId();
        $playerId = $request->getPlayerId();

        return app(PlayerFilterTask::class)
            ->run(
                [
                    'game_id' => $gameId,
                    'id' => $playerId,
                ]
            )
            ->first();
    }
}
