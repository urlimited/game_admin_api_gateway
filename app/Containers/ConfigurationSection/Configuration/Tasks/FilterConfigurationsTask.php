<?php

namespace App\Containers\ConfigurationSection\Configuration\Tasks;

use App\Containers\ConfigurationSection\Configuration\Data\Repositories\ConfigurationRepository;
use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Ship\Criterias\ThisEqualThatCriteria;
use App\Ship\Criterias\ThisWhereHasThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class FilterConfigurationsTask extends Task
{
    public function __construct(
        protected ConfigurationRepository $repository
    )
    {
    }

    /**
     * @throws RepositoryException
     */
    public function run(array $data): Collection
    {

        $result = $this->repository;

        foreach ($data as $key => $filterCriteria) {
            if ($key === 'structure_id') {
                if (!is_null($filterCriteria)) {
                    $result->where('structure_id', $filterCriteria);
                }
            } else {
                $result->where($key, $filterCriteria);
            }
        }

        return $result->orderBy('id', 'desc')->get();
    }
}
