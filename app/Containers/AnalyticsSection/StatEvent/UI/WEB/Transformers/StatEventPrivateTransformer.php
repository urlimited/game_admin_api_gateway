<?php

namespace App\Containers\AnalyticsSection\StatEvent\UI\WEB\Transformers;

use App\Containers\AnalyticsSection\StatEvent\Models\StatEvent;
use App\Ship\Parents\Transformers\Transformer;

class StatEventPrivateTransformer extends Transformer
{
    protected array $availableIncludes = [

    ];

    protected array $defaultIncludes = [

    ];

        public function transform(StatEvent $statEvent): array
    {
        return [
            'uuid' => $statEvent->getAttribute('uuidText'),
            'name' => $statEvent->getAttribute('name'),
            'type' => $statEvent->getAttribute('type'),
        ];
    }

}
