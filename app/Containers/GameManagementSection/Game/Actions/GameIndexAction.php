<?php

namespace App\Containers\GameManagementSection\Game\Actions;

use App\Containers\GameManagementSection\Game\Tasks\FilterGamesTask;
use App\Containers\GameManagementSection\Game\UI\WEB\Requests\GameWebIndexRequest;
use App\Ship\Parents\Actions\Action;

class GameIndexAction extends Action
{
    public function run(GameWebIndexRequest $request)
    {
        return app(FilterGamesTask::class)
            ->run(
                [
                    'user_id' => $request->user()->id
                ]
            );
    }
}
