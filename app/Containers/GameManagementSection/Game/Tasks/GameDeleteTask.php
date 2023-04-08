<?php

namespace App\Containers\GameManagementSection\Game\Tasks;

use App\Containers\GameManagementSection\Game\Data\Repositories\StructureRepository;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class GameDeleteTask extends Task
{
    protected StructureRepository $repository;

    public function __construct(StructureRepository $repository)
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
