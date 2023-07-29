<?php

namespace App\Containers\AnalyticsSection\StatEvent\Tasks;

use App\Containers\AnalyticsSection\StatEvent\Data\Repositories\StatEventRepository;
use App\Containers\AnalyticsSection\StatEvent\Models\StatEvent;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class StatEventUpdateTask extends Task
{
    public function __construct(
        protected StatEventRepository $repository
    )
    {
    }

    /**
     * @param array $data
     * @param int $statEventId
     * @return StatEvent
     * @throws ValidatorException
     */
    public function run(array $data, int $statEventId): StatEvent
    {
        return $this->repository->update($data, $statEventId);
    }
}
