<?php

namespace App\Containers\AppSection\User\UI\API\Transformers;

use App\Containers\AppSection\Permission\UI\API\Transformers\UserPermissionTransformer;
use App\Containers\AppSection\Role\UI\API\Transformers\UserRoleTransformer;
use App\Containers\AppSection\User\Models\User;
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
