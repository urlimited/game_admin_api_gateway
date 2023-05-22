<?php

namespace App\Containers\ConfigurationSection\Setting\Actions;


use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Ship\Parents\Actions\Action;

class SettingShowAction extends Action
{
    public function run(Setting $setting):Setting
    {
        return $setting;
    }
}
