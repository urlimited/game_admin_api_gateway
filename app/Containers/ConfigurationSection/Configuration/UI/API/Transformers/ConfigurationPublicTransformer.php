<?php

namespace App\Containers\ConfigurationSection\Configuration\UI\API\Transformers;

use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Ship\Parents\Transformers\Transformer;

class ConfigurationPublicTransformer extends Transformer
{
    protected array $availableIncludes = [

    ];

    protected array $defaultIncludes = [

    ];

        public function transform(Configuration $configuration): array
    {
        return [
            'id' => $configuration->id,
            'name' => $configuration->name,
            'schema' => $configuration->schema,
        ];
    }

}
