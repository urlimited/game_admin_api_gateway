<?php

namespace App\Containers\GameManagementSection\Game\Tasks;

use App\Containers\GameManagementSection\Game\Data\Repositories\GameRepository;
use App\Containers\GameManagementSection\Game\Models\Game;
use App\Ship\Criterias\ThisEqualThatCriteria;
use App\Ship\Criterias\ThisWhereHasThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class FilterGamesTask extends Task
{
    public function __construct(
        protected GameRepository $repository
    )
    {
    }

    /**
     * @param array $data
     * @return Collection<Game>
     * @throws RepositoryException
     */
    public function run(array $data): Collection
    {
            foreach ($data as $key => $filterCriteria) {
            if ($key === 'user_id' || $key === 'userId') {
                $this
                    ->repository
                    ->pushCriteria(new ThisWhereHasThatCriteria('users', $key, $filterCriteria));

                continue;
            }

            $this
                ->repository
                ->pushCriteria(new ThisEqualThatCriteria($key, $filterCriteria));
        }

        return $this->repository->orderBy('id', 'desc')->get();
    }
}
