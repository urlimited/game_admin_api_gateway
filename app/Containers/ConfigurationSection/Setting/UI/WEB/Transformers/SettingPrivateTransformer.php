<?php

namespace App\Containers\ConfigurationSection\Setting\UI\WEB\Transformers;

use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Ship\Parents\Transformers\Transformer;

class SettingPrivateTransformer extends Transformer
{
    protected array $availableIncludes = [

    ];

    protected array $defaultIncludes = [

    ];

        public function transform(Setting $setting): array
    {
        return [
            'uuid' => $setting->getAttribute('uuidText'),
            'name' => $setting->getAttribute('name'),
            'layout_uuid' => $setting->getAttribute('layout')?->getAttribute('uuidText'),
            'game_uuid' => $setting->getAttribute('game')->getAttribute('uuidText'),
            'schema' => $setting->getAttribute('schema'),
        ];
    }

}
