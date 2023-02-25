<?php

namespace App\Containers\AppSection\User\UI\API\Transformers;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Transformers\Transformer;

class UserPublicTransformer extends Transformer
{
    protected $availableIncludes = [

    ];

    protected $defaultIncludes = [

    ];

    public function transform(User $user): array
    {
        return [
            'id' => $user->id,
            'login' => $user->login,
        ];
    }
}
