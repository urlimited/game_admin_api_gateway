<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class UserUpdateTask extends Task
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws ValidatorException
     */
    public function run(
        int $id,
        string $status,
        array $roles,
        array $permissions,
    ): User
    {
        $user = $this
            ->repository
            ->update(
                [
                    'status' => $status
                ],
                $id
            );

        $user->roles()->sync($roles);
        $user->permissions()->sync($permissions);

        return $user;
    }
}
