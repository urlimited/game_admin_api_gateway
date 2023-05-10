<?php

namespace App\Containers\ConfigurationSection\Setting\UI\API\Transformers;

use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Ship\Parents\Transformers\Transformer;

class SettingPublicTransformer extends Transformer
{
    protected array $availableIncludes = [

    ];

    protected array $defaultIncludes = [

    ];

        public function transform(Setting $setting): array
    {
        return [
            'id' => $setting->id,
            'name' => $setting->name,
            'schema' => $setting->schema,
        ];
    }

}
