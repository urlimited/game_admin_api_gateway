<?php

namespace App\Containers\GameManagementSection\Game\Actions;

use App\Containers\GameManagementSection\Game\Tasks\FilterGamesTask;
use App\Containers\GameManagementSection\Game\UI\API\Requests\GameIndexRequest;
use App\Ship\Parents\Actions\Action;

class GameIndexAction extends Action
{
    public function run(GameIndexRequest $request)
    {
        return app(FilterGamesTask::class)
            ->run(
                [
                    'user_id' => $request->user()->id
                ]
            );
    }
}
