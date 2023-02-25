<?php

namespace App\Containers\GameManagementSection\Game\Actions;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tasks\GameDeleteTask;
use App\Containers\GameManagementSection\Game\UI\API\Requests\GameDeleteRequest;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;

class GameDeleteAction extends Action
{
    /**
     * @throws ValidatorException
     */
    public function run(GameDeleteRequest $request, Game $game)
    {
        return app(GameDeleteTask::class)
            ->run(
                id: $game->id
            );
    }
}
