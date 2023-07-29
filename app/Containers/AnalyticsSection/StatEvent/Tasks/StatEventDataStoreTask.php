<?php

namespace App\Containers\AnalyticsSection\StatEvent\Tasks;

use App\Containers\AnalyticsSection\StatEvent\Data\Repositories\StatEventDataRepository;
use App\Containers\AnalyticsSection\StatEvent\Models\StatEventData;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class StatEventDataStoreTask extends Task
{
    public function __construct(
        protected StatEventDataRepository $repository
    )
    {
    }

    /**
     * @param array $data
     * @return StatEventData
     * @throws ValidatorException
     */
    public function run(array $data): StatEventData
    {
        return $this->repository->create($data);
    }
}
