<?php

namespace App\Containers\AnalyticsSection\StatEvent\Tasks;

use App\Containers\AnalyticsSection\StatEvent\Data\Repositories\StatEventRepository;
use App\Ship\Criterias\ThisEqualThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class StatEventFilterTask extends Task
{
    public function __construct(
        protected StatEventRepository $repository
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
