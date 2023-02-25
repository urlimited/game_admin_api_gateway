<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Ship\Criterias\ThisEqualThatCriteria;
use App\Ship\Exceptions\FilterResourceFailedException;
use App\Ship\Parents\Exceptions\WrongFilterValueException;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Values\FilterValue;
use App\Containers\AppSection\Permission\Data\Repositories\PermissionRepository;
use Exception;
use Illuminate\Support\Collection;

class FilterUserPermissionsTask extends Task
{
    protected PermissionRepository $repository;

    public function __construct(PermissionRepository $repository)
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
            $roles = $this->repository;

            foreach ($filterData as $filterObject) {
                if ($filterObject->operator === '=') {
                    $roles->pushCriteria(new ThisEqualThatCriteria($filterObject->key, $filterObject->value));
                } else {
                    throw new WrongFilterValueException('operator does not exist for the case');
                }
            }

            return $roles->get();

        } catch (Exception $e) {
            throw new FilterResourceFailedException();
        }
    }
}
