<?php

namespace App\Containers\AppSection\Permission\Data\Repositories;

use App\Ship\Parents\Repositories\UserPermissionRepository as ParentUserPermissionRepository;
use App\Containers\AppSection\Permission\Models\Permission;

class PermissionRepository extends ParentUserPermissionRepository
{
    public function model(): string
    {
        return Permission::class;
    }
}
