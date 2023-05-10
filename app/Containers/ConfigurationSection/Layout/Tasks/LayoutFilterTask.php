<?php

namespace App\Containers\ConfigurationSection\Layout\Tasks;

use App\Containers\ConfigurationSection\Layout\Data\Repositories\LayoutRepository;
use App\Ship\Criterias\ThisEqualThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class LayoutFilterTask extends Task
{
    public function __construct(
        protected LayoutRepository $repository
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
