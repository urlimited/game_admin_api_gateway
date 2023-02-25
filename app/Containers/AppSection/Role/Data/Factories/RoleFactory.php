<?php

namespace App\Containers\AppSection\Role\Data\Factories;

use App\Ship\Parents\Factories\UserRoleFactory as ParentUserRoleFactory;
use App\Containers\AppSection\Role\Models\Role;

class RoleFactory extends ParentUserRoleFactory
{
    protected $model = Role::class;
}
