<?php

namespace App\Containers\AppSection\Permission\Data\Factories;

use App\Ship\Parents\Factories\UserPermissionFactory as ParentUserPermissionFactory;
use App\Containers\AppSection\Permission\Models\Permission;

class PermissionFactory extends ParentUserPermissionFactory
{
    protected $model = Permission::class;
}
