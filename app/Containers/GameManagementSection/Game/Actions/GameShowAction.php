<?php

namespace App\Containers\GameManagementSection\Game\Actions;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tasks\FilterGamesTask;
use App\Containers\GameManagementSection\Game\UI\WEB\Requests\GameWebShowRequest;
use App\Ship\Parents\Actions\Action;

class GameShowAction extends Action
{
    public function run(GameWebShowRequest $request)
    {
        return app(FilterGamesTask::class)
            ->run(
                [
                    'id' => $request->route('game_id')
                ]
            )
            ->first();
    }
}
