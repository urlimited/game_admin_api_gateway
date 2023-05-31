<?php

namespace App\Containers\AppSection\User\UI\WEB\Transformers;

use App\Ship\Parents\Models\User;
use App\Ship\Parents\Transformers\Transformer;

class UserPublicTransformer extends Transformer
{
    protected array $availableIncludes = [

    ];

    protected array $defaultIncludes = [

    ];

    public function transform(User $user): array
    {
        $roleNames = $user->roles()->pluck('name')->toArray();
        return [
            'uuid' => $user->getAttribute('uuidText'),
            'login' => $user->login,
            'role'=>$roleNames
        ];
    }
}
