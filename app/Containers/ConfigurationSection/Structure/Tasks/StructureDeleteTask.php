<?php

namespace App\Containers\ConfigurationSection\Structure\Tasks;

use App\Containers\ConfigurationSection\Structure\Data\Repositories\StructureRepository;
use App\Ship\Parents\Tasks\Task;

class StructureDeleteTask extends Task
{
    public function __construct(
        protected StructureRepository $repository
    )
    {
    }

    /**
     * @param int $id
     * @return void
     */
    public function run(int $id): void
    {
        $this->repository->delete($id);
    }
}
