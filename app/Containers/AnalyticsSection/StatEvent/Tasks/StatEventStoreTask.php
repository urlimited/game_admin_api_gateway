<?php

namespace App\Containers\AnalyticsSection\StatEvent\Tasks;

use App\Containers\AnalyticsSection\StatEvent\Data\Repositories\StatEventRepository;
use App\Containers\AnalyticsSection\StatEvent\Models\StatEvent;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class StatEventStoreTask extends Task
{
    public function __construct(
        protected StatEventRepository $repository
    )
    {
    }

    /**
     * @param array $data
     * @return StatEvent
     * @throws ValidatorException
     */
    public function run(array $data): StatEvent
    {
        return $this->repository->create($data);
    }
}
