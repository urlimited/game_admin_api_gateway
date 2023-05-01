<?php

namespace App\Containers\ConfigurationSection\Configuration\Tasks;

use App\Containers\ConfigurationSection\Configuration\Data\Repositories\ConfigurationRepository;
use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Ship\Criterias\ThisEqualThatCriteria;
use App\Ship\Criterias\ThisWhereHasThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class ConfigurationFilterTask extends Task
{
    public function __construct(
        protected ConfigurationRepository $repository
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
