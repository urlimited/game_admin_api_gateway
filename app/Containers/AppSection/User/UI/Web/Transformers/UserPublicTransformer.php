<?php

namespace App\Containers\AppSection\User\UI\Web\Transformers;

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
        return [
            'id' => $user->id,
            'login' => $user->login,
        ];
    }
}
