<?php

namespace App\Containers\ConfigurationSection\Configuration\Actions;

use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Configuration\Tasks\ConfigurationDeleteTask;
use App\Ship\Parents\Actions\Action;

class ConfigurationDeleteAction extends Action
{
    public function run(Configuration $configuration): void
    {
        app(ConfigurationDeleteTask::class)->run($configuration->getAttribute('id'));
    }
}
