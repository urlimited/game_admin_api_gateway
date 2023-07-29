<?php

namespace App\Containers\AnalyticsSection\StatEvent\Tasks;

use App\Containers\AnalyticsSection\StatEvent\Data\Repositories\StatEventRepository;
use App\Ship\Parents\Tasks\Task;

class StatEventDeleteTask extends Task
{
    public function __construct(
        protected StatEventRepository $repository
    )
    {
    }

    /**
     * @param int $statEventId
     * @return void
     */
    public function run(int $statEventId): void
    {
        $this->repository->delete($statEventId);
    }
}
