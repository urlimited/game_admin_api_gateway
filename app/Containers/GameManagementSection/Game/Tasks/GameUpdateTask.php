<?php

namespace App\Containers\GameManagementSection\Game\Tasks;

use App\Containers\GameManagementSection\Game\Data\Repositories\StructureRepository;
use App\Containers\GameManagementSection\Game\Models\Game;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class GameUpdateTask extends Task
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
        int $id,
        array $data
    ): Game
    {
        return $this
            ->repository
            ->update(
                $data,
                $id
            );
    }
}
