<?php

namespace App\Containers\ConfigurationSection\Configuration\Actions;


use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Configuration\Tasks\FilterConfigurationsTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;


class ConfigurationShowAction extends Action
{

    public function run(Configuration $configuration):Configuration
    {
        return app(FilterConfigurationsTask::class)
            ->run(
                [
                    'id' => $configuration->id
                ]
            )->first();
    }
}
