<?php

namespace App\Containers\ConfigurationSection\Setting\UI\API\Transformers;

use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\Setting\Tasks\SettingHideMetaDataTask;
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
            'id' => $setting->getAttribute('id'),
            'name' => $setting->getAttribute('name'),
            'schema' => app(SettingHideMetaDataTask::class)->run($setting->getAttribute('schema')),
        ];
    }

}
