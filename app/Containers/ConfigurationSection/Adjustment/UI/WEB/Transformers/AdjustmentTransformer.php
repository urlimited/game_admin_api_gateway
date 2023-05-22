<?php

namespace App\Containers\ConfigurationSection\Adjustment\UI\WEB\Transformers;

use App\Containers\ConfigurationSection\Adjustment\Models\Adjustment;
use App\Ship\Parents\Transformers\Transformer;

class AdjustmentTransformer extends Transformer
{
    protected array $availableIncludes = [

    ];

    protected array $defaultIncludes = [

    ];

    public function transform(Adjustment $adjustment): array
    {
        return [
            'uuid' => $adjustment->getAttribute('uuidText'),
            'name' => $adjustment->getAttribute('name'),
            'schema' => $adjustment->getAttribute('schema'),
        ];
    }
}
