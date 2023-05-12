<?php

namespace App\Containers\AppSection\User\UI\WEB\Transformers;

use App\Containers\AppSection\Permission\UI\WEB\Transformers\UserPermissionTransformer;
use App\Containers\AppSection\Role\UI\WEB\Transformers\UserRoleTransformer;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Transformers\Transformer;

class UserAuthTransformer extends Transformer
{
    protected array $availableIncludes = [

    ];

    protected array $defaultIncludes = [

    ];

    public function transform(User $user): array
    {
        return [
            'id' => $user->getAttribute('id'),
            'login' => $user->getAttribute('login'),
            'roles' => $user
                ->getAttribute('roles')
                ?->map(fn($role) => (new UserRoleTransformer())->transform($role)),
            'permissions' => $user
                ->getAttribute('permissions')
                ?->map(fn($permission) => (new UserPermissionTransformer())->transform($permission)),
            'status' => $user->getAttribute('status'),
        ];
    }
}