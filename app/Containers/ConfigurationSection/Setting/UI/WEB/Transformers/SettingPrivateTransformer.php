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
            'structure_id' => $setting->getAttribute('structure_id'),
            'game_id' => $setting->getAttribute('game_id'),
            'schema' => $setting->getAttribute('schema'),
            'author_id' =>$setting->getAttribute('author_id'),
        ];
    }

}
