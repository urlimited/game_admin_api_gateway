<?php

namespace App\Containers\AnalyticsSection\StatEvent\Actions;


use App\Containers\AnalyticsSection\StatEvent\Models\StatEvent;
use App\Containers\AnalyticsSection\StatEvent\Tasks\StatEventUpdateTask;
use App\Containers\AnalyticsSection\StatEvent\UI\WEB\Requests\StatEventWebUpdateRequest;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;

class StatEventUpdateAction extends Action
{
    /**
     * @param StatEventWebUpdateRequest $request
     * @param StatEvent $statEvent
     * @return StatEvent
     * @throws ValidatorException
     */
    public function run(StatEventWebUpdateRequest $request, StatEvent $statEvent): StatEvent
    {
        return app(StatEventUpdateTask::class)
            ->run(
                [
                    'name' => $request->get('name'),
                ],
                $statEvent->getAttribute('id')
            );
    }
}
