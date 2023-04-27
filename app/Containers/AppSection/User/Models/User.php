<?php

namespace App\Containers\AppSection\User\Models;

use App\Containers\AppSection\Permission\Models\Permission;
use App\Containers\AppSection\Role\Models\Role;
use App\Containers\AppSection\User\Data\Factories\UserFactory;
use App\Ship\Parents\Models\UserModel;
use Illuminate\Auth\Authenticatable;

/**
 * @method static UserFactory factory()
 */
class User extends UserModel
{
    use Authenticatable;

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_has_roles', 'user_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_has_permissions', 'user_id');
    }

    public function hasRole(array|string $rolesToBeChecked): bool
    {
        if (is_string($rolesToBeChecked)) {
            $rolesToBeChecked = [$rolesToBeChecked];
        }

        foreach ($rolesToBeChecked as $roleNameToBeChecked) {
            if (!$this->getAttribute('roles')->contains('name', $roleNameToBeChecked)) {
                return false;
            }
        }

        return true;
    }

    public function hasPermission(array|string $permissionsToBeChecked): bool
    {
        if (is_string($permissionsToBeChecked)) {
            $permissionsToBeChecked = [$permissionsToBeChecked];
        }

        $permissionsFromRoles = $this
            ->roles()
            ->with('permissions')
            ->get()
            ->map(
                fn(Role $role) => $role
                    ->permissions
                    ->map(fn(Permission $permission) => $permission->name)
            )->flatten();

        $permissionsFromUser = $this
            ->permissions
            ->map(fn(Permission $permission) => $permission->name)
            ->flatten();

        $totalPermissions = $permissionsFromRoles->merge($permissionsFromUser);

        if (is_string($permissionsToBeChecked)) {
            return $totalPermissions->contains($permissionsToBeChecked);
        }

        foreach ( $permissionsToBeChecked as $permissionToBeChecked) {
            if (!$totalPermissions->contains($permissionToBeChecked)) {
                return false;
            }
        }

        return true;
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
