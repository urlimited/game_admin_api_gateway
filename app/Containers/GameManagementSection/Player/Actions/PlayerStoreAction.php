<?php

namespace App\Containers\GameManagementSection\Player\Actions;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\Player\Tasks\PlayerCreateTask;
use App\Containers\GameManagementSection\Player\UI\Contracts\Requests\PlayerStoreRequestContract;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;
use Ramsey\Uuid\Uuid;

class PlayerStoreAction extends Action
{
    /**
     * @throws ValidatorException
     */
    public function run(PlayerStoreRequestContract $request): Player
    {
        $gameId = $request->getGameId();

        $player = app(PlayerCreateTask::class)
            ->run(
                login: $request->get('login'),
                gameId: $gameId,
                password: $request->get('password'),
            );

        $token = $player->createToken('player-api-token')->plainTextToken;

        $player->apiToken = $token;

        return $player;
    }
}
