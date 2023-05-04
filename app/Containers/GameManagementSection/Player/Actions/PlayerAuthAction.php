<?php

namespace App\Containers\GameManagementSection\Player\Actions;

use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\Player\Tasks\PlayerFilterTask;
use App\Containers\GameManagementSection\Player\UI\API\Requests\PlayerApiAuthRequest;
use App\Ship\Exceptions\AuthenticationException;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Prettus\Repository\Exceptions\RepositoryException;

class PlayerAuthAction extends Action
{
    /**
     * @param PlayerApiAuthRequest $request
     * @return Player
     * @throws AuthenticationException
     * @throws RepositoryException
     */
    public function run(PlayerApiAuthRequest $request): Player
    {
        $gameId = $request->getGameId();

        $player = app(PlayerFilterTask::class)
            ->run(
                [
                    'login' => $request->get('login'),
                    'game_id' => $gameId,
                ]
            )
            ->first();

        if (!Hash::check($request->get('password'), $player->getAttribute('password'))) {
            throw new AuthenticationException('Player\'s credentials are not correct');
        }

        $player->tokens()->delete();

        $token = $player->createToken('player-api-token')->plainTextToken;

        $player->apiToken = $token;

        return $player;
    }
}
