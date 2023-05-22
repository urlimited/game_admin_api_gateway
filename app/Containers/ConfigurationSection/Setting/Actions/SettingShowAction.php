<?php

namespace App\Containers\ConfigurationSection\Setting\Actions;


use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\Setting\Tasks\SettingFilterTask;
use App\Containers\ConfigurationSection\Setting\Tasks\SettingMetaTask;
use App\Ship\Parents\Actions\Action;

class SettingShowAction extends Action
{

    public function run(Setting $setting):Setting
    {
        return app(SettingFilterTask::class)
            ->run(
                [
                    'id' => $setting->id,
                    'structure_id' => $setting->structure_id,
                ]
            )->first();
    }
    public function setMeta(?int $structureId):array{
        return app(SettingMetaTask::class)
            ->run($structureId);
    }

}
