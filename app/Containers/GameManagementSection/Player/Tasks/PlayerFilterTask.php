<?php

namespace App\Containers\GameManagementSection\Player\Tasks;

use App\Containers\GameManagementSection\Player\Data\Repositories\PlayerRepository;
use App\Containers\GameManagementSection\Player\Models\Player;
use App\Ship\Criterias\ThisEqualThatCriteria;
use App\Ship\Criterias\ThisWhereHasThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class PlayerFilterTask extends Task
{
    protected PlayerRepository $repository;

    public function __construct(PlayerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @return Collection<Player>
     * @throws RepositoryException
     */
    public function run(
        array $data
    ): Collection
    {
        foreach ($data as $key => $filterCriteria) {
            if ($key === 'game_id' || $key === 'gameId') {
                $this
                    ->repository
                    ->pushCriteria(new ThisWhereHasThatCriteria('game', $key, $filterCriteria));

                continue;
            }

            $this
                ->repository
                ->pushCriteria(new ThisEqualThatCriteria($key, $filterCriteria));
        }

        return $this->repository->orderBy('id', 'desc')->get();
    }
}
