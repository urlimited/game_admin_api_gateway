<?php

namespace App\Containers\GameManagementSection\Game\Actions;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tasks\GameUpdateTask;
use App\Containers\GameManagementSection\Game\UI\API\Requests\GameUpdateRequest;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;

class GameUpdateAction extends Action
{
    /**
     * @throws ValidatorException
     */
    public function run(GameUpdateRequest $request, Game $game): Game
    {
        return app(GameUpdateTask::class)
            ->run(
                id: $game->id,
                data: [
                    'name' => $request->get('name')
                ]
            );
    }
}
