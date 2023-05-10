<?php

namespace App\Containers\ConfigurationSection\Setting\Actions;

use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\Setting\Tasks\SettingDeleteTask;
use App\Ship\Parents\Actions\Action;

class SettingDeleteAction extends Action
{
    public function run(Setting $setting): void
    {
        app(SettingDeleteTask::class)->run($setting->getAttribute('id'));
    }
}
