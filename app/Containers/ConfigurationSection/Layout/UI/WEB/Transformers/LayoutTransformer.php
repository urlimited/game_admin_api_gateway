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
            'id' => $layout->id,
            'name' => $layout->name,
            'version' => $layout->version,
            'schema' => $layout->schema
        ];
    }
}
