<?php

namespace App\Containers\ConfigurationSection\Setting\Actions;


use App\Containers\ConfigurationSection\Setting\Tasks\SettingFilterTask;
use App\Containers\ConfigurationSection\Setting\Tasks\SettingMetaTask;
use App\Containers\ConfigurationSection\Setting\UI\WEB\Requests\SettingWebIndexRequest;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class SettingMetaAction extends Action
{
    public function run($transform): array
    {
        return app(SettingMetaTask::class)
            ->run($transform);
    }
}
