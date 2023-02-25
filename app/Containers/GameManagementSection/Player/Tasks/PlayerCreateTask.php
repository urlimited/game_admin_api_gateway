<?php

namespace App\Containers\GameManagementSection\Player\Tasks;

use App\Containers\GameManagementSection\Player\Data\Repositories\PlayerRepository;
use App\Containers\GameManagementSection\Player\Models\Player;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\Hash;
use Prettus\Validator\Exceptions\ValidatorException;

class PlayerCreateTask extends Task
{
    protected PlayerRepository $repository;

    public function __construct(PlayerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws ValidatorException
     */
    public function run(
        string $login,
        int $gameId,
        string $password,
    ): Player
    {
        return $this
            ->repository
            ->create(
                [
                    'login' => $login,
                    'game_id' => $gameId,
                    'password' => Hash::make($password)
                ]
            );
    }
}
