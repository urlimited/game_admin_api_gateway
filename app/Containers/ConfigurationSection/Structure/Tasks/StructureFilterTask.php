<?php

namespace App\Containers\ConfigurationSection\Structure\Tasks;

use App\Containers\ConfigurationSection\Structure\Data\Repositories\StructureRepository;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Ship\Criterias\ThisEqualThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class StructureFilterTask extends Task
{
    public function __construct(
        protected StructureRepository $repository
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
            if ($key === 'game_id') {
                if (!is_null($filterCriteria)) {
                    $result->pushCriteria(new ThisEqualThatCriteria('game_id', $filterCriteria));
                }
            } else {
                $result->pushCriteria(new ThisEqualThatCriteria($key, $filterCriteria));
            }
        }

        return $result->orderBy('id', 'desc')->get();
    }
}
