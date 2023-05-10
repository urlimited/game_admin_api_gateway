<?php

namespace App\Containers\ConfigurationSection\Setting\Tasks;

use App\Containers\ConfigurationSection\Setting\Data\Repositories\SettingRepository;
use App\Ship\Criterias\ThisEqualThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class SettingFilterTask extends Task
{
    public function __construct(
        protected SettingRepository $repository
    )
    {
    }

    public function run(array $data): Collection
    {

        $result = $this->repository;

        foreach ($data as $key => $filterCriteria) {
            if ($key === 'structure_id') {
                if (!is_null($filterCriteria)) {
                    $result->pushCriteria(new ThisEqualThatCriteria('structure_id', $filterCriteria));
                }
            } else {
                $result->pushCriteria(new ThisEqualThatCriteria($key, $filterCriteria));
            }
        }

        return $result->orderBy('id', 'desc')->get();
    }
}
