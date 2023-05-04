<?php

namespace App\Containers\GameManagementSection\Game\Actions;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tasks\FilterGamesTask;
use App\Containers\GameManagementSection\Game\UI\Web\Requests\GameWebShowRequest;
use App\Ship\Parents\Actions\Action;

class GameShowAction extends Action
{
    public function run(GameWebShowRequest $request, Game $game)
    {
        return app(FilterGamesTask::class)
            ->run(
                [
                    'id' => $game->id
                ]
            )
            ->first();
    }
}
