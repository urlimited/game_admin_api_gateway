<?php

namespace App\Containers\ConfigurationSection\Structure\Tasks;

use App\Containers\ConfigurationSection\Structure\Data\Repositories\StructureRepository;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Ship\Criterias\ThisEqualThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class StructureIndexTask extends Task
{
    public function __construct(
        protected StructureRepository $repository
    )
    {
    }

    /**
     * @throws RepositoryException
     */
    public function run(int $gameId): Collection
    {
        return $this
            ->repository
            ->pushCriteria(
                new ThisEqualThatCriteria('game_id', $gameId)
            )
            ->get();
    }
}
