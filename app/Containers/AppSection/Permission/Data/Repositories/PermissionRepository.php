<?php

namespace App\Containers\AppSection\Permission\Data\Repositories;

use App\Ship\Parents\Models\Permission;
use App\Ship\Parents\Repositories\UserPermissionRepository as ParentUserPermissionRepository;

class PermissionRepository extends ParentUserPermissionRepository
{
    public function model(): string
    {
        return Permission::class;
    }
}
