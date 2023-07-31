<?php

namespace App\Containers\AnalyticsSection\TargetGroup\Tasks;

use App\Containers\AnalyticsSection\TargetGroup\Data\Repositories\TargetGroupRepository;
use App\Ship\Parents\Tasks\Task;

class TargetGroupDeleteTask extends Task
{
    public function __construct(
        protected TargetGroupRepository $repository
    )
    {
    }

    /**
     * @param int $targetGroupId
     * @return void
     */
    public function run(int $targetGroupId): void
    {
        $this->repository->delete($targetGroupId);
    }
}
