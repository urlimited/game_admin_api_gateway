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
            'id' => $setting->id,
            'name' => $setting->name,
            'structure_id' => $setting->structure_id,
            'game_id' => $setting->game_id,
            'schema' => $setting->schema,
            'author_id'=>$setting->author_id,
        ];
    }

}
