<?php

namespace App\Containers\GameManagementSection\Player\Actions;

use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\Player\Tasks\PlayerFilterTask;
use App\Containers\GameManagementSection\Player\Tasks\PlayerUpdateTask;
use App\Containers\GameManagementSection\Player\UI\Contracts\Requests\PlayerUpdateRequestContract;
use App\Ship\Exceptions\AuthenticationException;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class PlayerUpdateAction extends Action
{
    /**
     * @throws ValidatorException
     * @throws AuthenticationException
     * @throws RepositoryException
     */
    public function run(PlayerUpdateRequestContract $request): Player
    {
        $player = app(PlayerFilterTask::class)
            ->run(
                data: [
                    'id' => $request->getPlayerId()
                ]
            )
            ->first();

        $data = [];

        if ($request->has('password')) {
            $data['password'] = Hash::make($request->get('password'));
        }

        return app(PlayerUpdateTask::class)
            ->run(
                id: $player->getAttribute('id'),
                data: $data
            );
    }
}
