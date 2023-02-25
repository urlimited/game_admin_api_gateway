<?php

namespace App\Containers\AppSection\Permission\Models;

use App\Containers\AppSection\Role\Models\Role;
use App\Ship\Parents\Models\PermissionModel as ParentPermissionModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends ParentPermissionModel
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permissions_to_roles');
    }
}
