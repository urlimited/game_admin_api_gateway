<?php

namespace App\Containers\AnalyticsSection\TargetGroup\Tasks;

use App\Containers\AnalyticsSection\TargetGroup\Data\Repositories\TargetGroupRepository;
use App\Containers\AnalyticsSection\TargetGroup\Models\TargetGroup;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class TargetGroupUpdateTask extends Task
{
    public function __construct(
        protected TargetGroupRepository $repository
    )
    {
    }

    /**
     * @param array $data
     * @param int $id
     * @return TargetGroup
     * @throws ValidatorException
     */
    public function run(int $id, array $data): TargetGroup
    {
        return $this->repository->update($data, $id);
    }
}
