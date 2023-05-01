<?php

namespace App\Containers\ConfigurationSection\Structure\UI\API\Transformers;

use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Ship\Parents\Transformers\Transformer;

class StructureTransformer extends Transformer
{
    protected array $availableIncludes = [

    ];

    protected array $defaultIncludes = [

    ];

    public function transform(Structure $structure): array
    {
        return [
            'id' => $structure->id,
            'name' => $structure->name,
            'version' => $structure->version,
            'schema' => $structure->fields
        ];
    }
}
