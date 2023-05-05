<?php

namespace App\Containers\GameManagementSection\Player\Actions;

use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\Player\Tasks\PlayerDeleteTask;
use App\Containers\GameManagementSection\Player\UI\WEB\Requests\PlayerDeleteRequest;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;

class PlayerDeleteAction extends Action
{
    /**
     * @throws ValidatorException
     */
    public function run(PlayerDeleteRequest $request, Player $player): Player
    {
        return app(PlayerDeleteTask::class)
            ->run(
                id: $player->id
            );
    }
}
