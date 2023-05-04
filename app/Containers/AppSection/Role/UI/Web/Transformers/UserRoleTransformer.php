<?php

namespace App\Containers\AppSection\Role\UI\Web\Transformers;

use App\Ship\Parents\Transformers\Transformer;
use App\Containers\AppSection\Role\Models\Role;

class UserRoleTransformer extends Transformer
{
    protected array $availableIncludes = [

    ];

    protected array $defaultIncludes = [

    ];

    public function transform(Role $role): array
    {
        return [
            'id' => $role->getAttribute('id'),
            'name' => $role->getAttribute('name'),
            'display_name' => $role->getAttribute('display_name'),
        ];
    }
}