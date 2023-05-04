<?php

namespace App\Containers\AppSection\Permission\UI\Web\Transformers;

use App\Ship\Parents\Transformers\Transformer;
use App\Containers\AppSection\Permission\Models\Permission;

class UserPermissionTransformer extends Transformer
{
    protected array $availableIncludes = [

    ];

    protected array $defaultIncludes = [

    ];

    public function transform(Permission $permission): array
    {
        return [
            'id' => $permission->getAttribute('id'),
            'name' => $permission->getAttribute('name'),
            'display_name' => $permission->getAttribute('description'),
        ];
    }
}
