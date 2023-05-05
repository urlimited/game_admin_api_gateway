<?php

namespace App\Containers\AppSection\Role\UI\WEB\Transformers;

use App\Ship\Parents\Models\Role;
use App\Ship\Parents\Transformers\Transformer;

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
