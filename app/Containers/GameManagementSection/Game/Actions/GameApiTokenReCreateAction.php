<?php

namespace App\Containers\GameManagementSection\Game\Actions;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\UI\WEB\Requests\GameWebApiTokenReCreateRequest;
use App\Ship\Parents\Actions\Action;

class GameApiTokenReCreateAction extends Action
{
    public function run(GameWebApiTokenReCreateRequest $request, Game $game): Game
    {
        $game->tokens()->delete();

        $token = $game->createToken($request->get('api_token_name', 'game-api-token'))->plainTextToken;

        $game->apiToken = $token;

        return $game;
    }
}
