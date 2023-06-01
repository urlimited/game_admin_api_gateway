<?php

namespace App\Containers\ConfigurationSection\Adjustment\Tasks;

use App\Containers\ConfigurationSection\Layout\Data\Repositories\LayoutRepository;
use App\Ship\Parents\Tasks\Task;

class AdjustmentDeleteTask extends Task
{
    public function __construct(
        protected LayoutRepository $repository
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
