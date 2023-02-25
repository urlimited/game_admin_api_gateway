<?php

namespace App\Containers\AppSection\User\UI\API\Transformers;

use App\Containers\AppSection\Permission\UI\API\Transformers\UserPermissionTransformer;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Transformers\Transformer;
use App\Containers\AppSection\Role\UI\API\Transformers\UserRoleTransformer;

class UserPrivateTransformer extends Transformer
{
    protected $availableIncludes = [

    ];

    protected $defaultIncludes = [

    ];

    public function transform(User $user): array
    {
        return [
            'id' => $user->getAttribute('id'),
            'login' => $user->getAttribute('login'),
            'status' => $user->getAttribute('status'),
            'roles' => $user
                ->getAttribute('roles')
                ?->map(fn($role) => (new UserRoleTransformer())->transform($role)),
            'permissions' => $user
                ->getAttribute('permissions')
                ?->map(fn($permission) => (new UserPermissionTransformer())->transform($permission)),
            'created_at' => $user->getAttribute('created_at'),
            'updated_at' => $user->getAttribute('updated_at')
        ];
    }
}
