<?php

namespace App\Containers\ConfigurationSection\Setting\Actions;


use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\Setting\Tasks\SettingFilterTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;


class SettingShowAction extends Action
{

    public function run(Setting $setting):Setting
    {
        return app(SettingFilterTask::class)
            ->run(
                [
                    'id' => $setting->id
                ]
            )->first();
    }
}
