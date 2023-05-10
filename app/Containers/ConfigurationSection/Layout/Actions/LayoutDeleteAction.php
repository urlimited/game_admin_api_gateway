<?php

namespace App\Containers\ConfigurationSection\Layout\Actions;

use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Containers\ConfigurationSection\Layout\Tasks\LayoutDeleteTask;
use App\Ship\Parents\Actions\Action;

class LayoutDeleteAction extends Action
{
    public function run(Layout $layout): void
    {
        app(LayoutDeleteTask::class)->run($layout->getAttribute('id'));
    }
}
