<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Ship\Criterias\ThisEqualThatCriteria;
use App\Ship\Exceptions\FilterResourceFailedException;
use App\Ship\Parents\Exceptions\WrongFilterValueException;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Values\FilterValue;
use Exception;
use Illuminate\Support\Collection;

class FilterUsersTask extends Task
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array<FilterValue> $filterData
     * @return Collection
     * @throws FilterResourceFailedException
     */
    public function run(
        array $filterData = []
    ): Collection
    {
        try {
            // create new user
            $users = $this->repository;

            foreach ($filterData as $filterObject) {
                if ($filterObject->operator === '=') {
                    $users->pushCriteria(new ThisEqualThatCriteria($filterObject->key, $filterObject->value));
                } else {
                    throw new WrongFilterValueException('operator does not exist for the case');
                }
            }

            return $users->get();

        } catch (Exception $e) {
            throw new FilterResourceFailedException();
        }
    }
}
