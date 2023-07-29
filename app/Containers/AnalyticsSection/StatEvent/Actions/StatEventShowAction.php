<?php

namespace App\Containers\AnalyticsSection\StatEvent\Actions;

use App\Containers\AnalyticsSection\StatEvent\Models\StatEvent;
use App\Containers\AnalyticsSection\StatEvent\Tasks\StatEventFilterTask;
use App\Ship\Parents\Actions\Action;

class StatEventShowAction extends Action
{
    /**
     * @param StatEvent $statEvent
     * @return StatEvent|null
     */
    public function run(StatEvent $statEvent): ?StatEvent
    {
        $statEvent = app(StatEventFilterTask::class)
            ->run(
                [
                    'id' => $statEvent->getAttribute('id'),
                ],
            );

        return $statEvent->isNotEmpty() ? $statEvent->first() : null;
    }
}
