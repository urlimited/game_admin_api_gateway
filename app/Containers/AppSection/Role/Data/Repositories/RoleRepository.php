<?php

namespace App\Containers\AppSection\Role\Data\Repositories;

use App\Ship\Parents\Repositories\UserRoleRepository as ParentUserRoleRepository;
use App\Containers\AppSection\Role\Models\Role;

class RoleRepository extends ParentUserRoleRepository
{
    public function model(): string
    {
        return Role::class;
    }
}
