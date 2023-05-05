<?php

namespace App\Containers\AppSection\Permission\Tasks;

use App\Containers\AppSection\Permission\Data\Repositories\PermissionRepository;
use App\Ship\Parents\Models\Permission;
use App\Ship\Parents\Tasks\Task;

class StorePermissionTask extends Task
{
    public function __construct(
        protected PermissionRepository $repository
    )
    {
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
