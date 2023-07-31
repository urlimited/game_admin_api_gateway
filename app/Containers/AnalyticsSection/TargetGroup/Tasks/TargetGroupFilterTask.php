<?php

namespace App\Containers\AnalyticsSection\TargetGroup\Tasks;

use App\Containers\AnalyticsSection\TargetGroup\Data\Repositories\TargetGroupRepository;
use App\Ship\Criterias\ThisEqualThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class TargetGroupFilterTask extends Task
{
    public function __construct(
        protected TargetGroupRepository $repository
    )
    {
    }

    public function run(array $data): Collection
    {
        $result = $this->repository;

        foreach ($data as $key => $filterCriteria) {
            $result->pushCriteria(new ThisEqualThatCriteria($key, $filterCriteria));
        }

        return $result->orderBy('id', 'desc')->get();
    }
}
