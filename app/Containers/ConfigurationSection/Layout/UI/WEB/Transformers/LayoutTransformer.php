<?php

namespace App\Containers\ConfigurationSection\Layout\UI\WEB\Transformers;

use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Ship\Parents\Transformers\Transformer;

class LayoutTransformer extends Transformer
{
    protected array $availableIncludes = [

    ];

    protected array $defaultIncludes = [

    ];

    public function transform(Layout $layout): array
    {
        return [
            'uuid' => $layout->getAttribute('uuidText'),
            'name' => $layout->getAttribute('name'),
            'version' => $layout->getAttribute('version'),
            'schema' => $layout->getAttribute('schema')
        ];
    }
}
