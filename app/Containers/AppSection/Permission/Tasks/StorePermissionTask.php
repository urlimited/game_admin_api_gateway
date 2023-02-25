<?php

namespace App\Containers\AppSection\Permission\Tasks;

use App\Containers\AppSection\Permission\Data\Repositories\PermissionRepository;
use App\Containers\AppSection\Permission\Models\Permission;
use App\Ship\Parents\Factories\UserRoleFactory as ParentUserRoleFactory;

class StorePermissionTask extends ParentUserRoleFactory
{
    protected PermissionRepository $repository;

    public function __construct(PermissionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $name, string $description = null, string $displayName = null): Permission
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
