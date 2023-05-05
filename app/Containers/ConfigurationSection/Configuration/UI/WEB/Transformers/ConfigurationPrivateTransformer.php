<?php

namespace App\Containers\ConfigurationSection\Configuration\UI\WEB\Transformers;

use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Ship\Parents\Transformers\Transformer;

class ConfigurationPrivateTransformer extends Transformer
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
            'structure_id' => $configuration->structure_id,
            'game_id' => $configuration->game_id,
            'schema' => $configuration->schema,
            'author_id'=>$configuration->author_id,
        ];
    }

}
