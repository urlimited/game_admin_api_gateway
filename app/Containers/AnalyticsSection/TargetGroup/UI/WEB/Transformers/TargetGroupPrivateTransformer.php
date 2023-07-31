<?php

namespace App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Transformers;

use App\Containers\AnalyticsSection\TargetGroup\Models\TargetGroup;
use App\Ship\Parents\Transformers\Transformer;

class TargetGroupPrivateTransformer extends Transformer
{
    protected array $availableIncludes = [

    ];

    protected array $defaultIncludes = [

    ];

        public function transform(TargetGroup $targetGroup): array
    {
        return [
            'uuid' => $targetGroup->getAttribute('uuidText'),
            'name' => $targetGroup->getAttribute('name'),
            'conditions' => $targetGroup->getAttribute('type'),
        ];
    }

}
