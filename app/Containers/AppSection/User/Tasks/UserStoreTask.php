<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserStoreTask extends Task
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(
        string $login,
        string $password,
        array $roles,
        array $permissions,
        string $status,
    ):User {
        try {
            // create new user
            $user = $this->repository->create(
                [
                    'password' => Hash::make($password),
                    'login' => $login,
                    'status' => $status,
                ]
            );

            foreach ($roles as $roleId) {
                $user->roles()->attach($roleId);
            }

            foreach ($permissions as $permissionId) {
                $user->permissions()->attach($permissionId);
            }

        } catch (Exception $e) {
            Log::debug($e->getMessage());
            throw new CreateResourceFailedException();
        }

        return $user;
    }
}
