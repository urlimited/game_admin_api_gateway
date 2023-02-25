<?php

namespace App\Containers\AppSection\Role\Models;

use App\Containers\AppSection\Permission\Models\Permission;
use App\Ship\Parents\Models\RoleModel as ParentRoleModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends ParentRoleModel
{
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permissions_to_roles');
    }
}
