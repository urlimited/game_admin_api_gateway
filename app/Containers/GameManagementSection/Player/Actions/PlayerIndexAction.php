<?php

namespace App\Containers\GameManagementSection\Player\Actions;

use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\Player\Tasks\PlayerFilterTask;
use App\Containers\GameManagementSection\Player\UI\API\Requests\PlayerPrivateIndexRequest;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class PlayerIndexAction extends Action
{
    /**
     * @param PlayerPrivateIndexRequest $request
     * @return Collection<Player>
     * @throws RepositoryException
     */
    public function run(PlayerPrivateIndexRequest $request): Collection
    {
        $gameId = $request->getGameId();

        return app(PlayerFilterTask::class)
            ->run(
                [
                    'game_id' => $gameId,
                ]
            );
    }
}
