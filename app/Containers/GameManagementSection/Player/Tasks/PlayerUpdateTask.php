<?php

namespace App\Containers\GameManagementSection\Player\Tasks;

use App\Containers\GameManagementSection\Player\Data\Repositories\PlayerRepository;
use App\Containers\GameManagementSection\Player\Models\Player;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class PlayerUpdateTask extends Task
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
        int $id,
        array $data,
    ): Player
    {
        return $this
            ->repository
            ->update(
                $data,
                $id
            );
    }
}
