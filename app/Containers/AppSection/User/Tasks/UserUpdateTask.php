<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Ship\Parents\Models\User;
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
        int   $id,
        array $data,
    ): User
    {
        $user = $this
            ->repository
            ->update(
                $data,
                $id
            );

        if (array_key_exists('roles', $data)) {
            $user->roles()->sync($data['roles']);
        }

        if (array_key_exists('permissions', $data)) {
            $user->permissions()->sync($data['permissions']);
        }

        return $user;
    }
}
