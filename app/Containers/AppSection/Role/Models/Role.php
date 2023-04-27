<?php

namespace App\Containers\AppSection\Role\Models;

use App\Containers\AppSection\Permission\Models\Permission;

use App\Containers\AppSection\Role\Data\Factories\RoleFactory;
use App\Ship\Parents\Models\RoleModel as ParentRoleModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends ParentRoleModel
{
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permissions_to_roles');
    }
    protected static function newFactory(): RoleFactory
    {
        return RoleFactory::new();
    }
}
