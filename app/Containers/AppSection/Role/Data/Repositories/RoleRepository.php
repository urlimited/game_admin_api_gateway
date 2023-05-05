<?php

namespace App\Containers\AppSection\Role\Data\Repositories;

use App\Ship\Parents\Models\Role;
use App\Ship\Parents\Repositories\UserRoleRepository as ParentUserRoleRepository;

class RoleRepository extends ParentUserRoleRepository
{
    public function model(): string
    {
        return Role::class;
    }
}
