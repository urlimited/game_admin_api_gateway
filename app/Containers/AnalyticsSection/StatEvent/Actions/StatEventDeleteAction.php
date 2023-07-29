<?php

namespace App\Containers\AnalyticsSection\StatEvent\Actions;


use App\Containers\AnalyticsSection\StatEvent\Models\StatEvent;
use App\Containers\AnalyticsSection\StatEvent\Tasks\StatEventDeleteTask;
use App\Ship\Parents\Actions\Action;

class StatEventDeleteAction extends Action
{
    /**
     * @param StatEvent $statEvent
     * @return void
     */
    public function run(StatEvent $statEvent): void
    {
        app(StatEventDeleteTask::class)
            ->run($statEvent->getAttribute('id'));
    }
}
