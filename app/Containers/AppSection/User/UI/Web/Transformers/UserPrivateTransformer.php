<?php

namespace App\Containers\AppSection\User\UI\Web\Transformers;

use App\Containers\AppSection\Permission\UI\Web\Transformers\UserPermissionTransformer;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Transformers\Transformer;
use App\Containers\AppSection\Role\UI\Web\Transformers\UserRoleTransformer;

class UserPrivateTransformer extends Transformer
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
