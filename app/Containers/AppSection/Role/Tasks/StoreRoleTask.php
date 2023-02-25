<?php

namespace App\Containers\AppSection\Role\Tasks;

use App\Containers\AppSection\Role\Data\Repositories\RoleRepository;
use App\Ship\Parents\Factories\UserRoleFactory as ParentUserRoleFactory;
use App\Containers\AppSection\Role\Models\Role;

class StoreRoleTask extends ParentUserRoleFactory
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
