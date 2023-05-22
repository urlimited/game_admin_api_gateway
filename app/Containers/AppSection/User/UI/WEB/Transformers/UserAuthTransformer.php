<?php

namespace App\Containers\AppSection\User\UI\WEB\Transformers;

use App\Containers\AppSection\Permission\UI\WEB\Transformers\UserPermissionTransformer;
use App\Containers\AppSection\Role\UI\WEB\Transformers\UserRoleTransformer;
use App\Containers\GameManagementSection\Game\UI\WEB\Transformers\GamePrivateTransformer;
use App\Containers\GameManagementSection\Game\UI\WEB\Transformers\GamePublicTransformer;
use App\Ship\Parents\Models\Permission;
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

        $rolePermissions =$user
            ->getAttribute('roles')
            ->load('permissions')
            ->pluck('permissions')
            ->flatten();
        $allPermissions =$rolePermissions->merge($user->getAttribute('permissions'));
        return [
            'uuid' => $user->getAttribute('uuidText'),
            'login' => $user->getAttribute('login'),
            'roles' => $user
                ->getAttribute('roles')
                ?->map(fn($role) => (new UserRoleTransformer())->transform($role)),
            'permissions' => $allPermissions
                ->map(fn($permission) => (new UserPermissionTransformer())->transform($permission)),
            'games'=>$user->getAttribute('games')?->map(fn($game) => (new GamePrivateTransformer())->transform($game)),
        ];
    }
}
