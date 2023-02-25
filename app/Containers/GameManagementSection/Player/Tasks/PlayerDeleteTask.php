<?php

namespace App\Containers\GameManagementSection\Player\Tasks;

use App\Containers\GameManagementSection\Player\Data\Repositories\PlayerRepository;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class PlayerDeleteTask extends Task
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
        int $id
    ): int
    {
        return $this
            ->repository
            ->delete(
                $id
            );
    }
}
