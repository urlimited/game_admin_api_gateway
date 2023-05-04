<?php

namespace App\Containers\GameManagementSection\Game\Actions;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tasks\GameCreateTask;
use App\Containers\GameManagementSection\Game\UI\Web\Requests\GameWebStoreRequest;
use App\Ship\Parents\Actions\Action;

class GameStoreAction extends Action
{
    public function run(GameWebStoreRequest $request): Game
    {
        $game = app(GameCreateTask::class)
            ->run(
                name: $request->get('name'),
                genre: $request->get('genre'),
                userId: $request->user()->id,
            );

        $token = $game->createToken('game-api-token')->plainTextToken;

        $game->apiToken = $token;

        return $game;
    }
}
