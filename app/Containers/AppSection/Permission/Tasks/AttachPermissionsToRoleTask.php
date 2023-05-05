<?php

namespace App\Containers\AppSection\Permission\Tasks;

use App\Containers\AppSection\Permission\Data\Repositories\PermissionRepository;
use App\Containers\AppSection\Role\Data\Repositories\RoleRepository;
use App\Ship\Parents\Factories\RoleFactory as ParentUserRoleFactory;

class AttachPermissionsToRoleTask extends ParentUserRoleFactory
{
    public function __construct(
        protected PermissionRepository $permissionRepository,
        protected RoleRepository $roleRepository,
    )
    {
    }

    public function run(string $role, array $permissions)
    {
        $role = $this->roleRepository->findByField('name', $role)->first();

        array_map( function ($permissionName) use ($role) {
            $permissionId = $this
                ->permissionRepository
                ->findByField('name', $permissionName)
                ->first()
                ->getAttribute('id');

            $role->permissions()->attach($permissionId);
        }, $permissions);
    }
}
