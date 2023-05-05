<?php

namespace App\Containers\AppSection\Role\Tasks;

use App\Containers\AppSection\Role\Data\Repositories\RoleRepository;
use App\Ship\Parents\Models\Role;
use App\Ship\Parents\Tasks\Task;

class StoreRoleTask extends Task
{
    protected RoleRepository $repository;

    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $name, string $description = null, string $displayName = null): Role
    {
        return $this->repository->create(
            [
                'name' => strtolower($name),
                'description' => $description,
                'display_name' => $displayName,
            ]
        );
    }
}
