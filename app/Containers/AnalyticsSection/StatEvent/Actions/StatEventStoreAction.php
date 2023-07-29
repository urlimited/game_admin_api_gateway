<?php

namespace App\Containers\AnalyticsSection\StatEvent\Actions;


use App\Containers\AnalyticsSection\StatEvent\Models\StatEvent;
use App\Containers\AnalyticsSection\StatEvent\Tasks\StatEventStoreTask;
use App\Containers\AnalyticsSection\StatEvent\UI\WEB\Requests\StatEventWebStoreRequest;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;

class StatEventStoreAction extends Action
{
    /**
     * @param StatEventWebStoreRequest $request
     * @return StatEvent
     * @throws ValidatorException
     */
    public function run(StatEventWebStoreRequest $request): StatEvent
    {
        return app(StatEventStoreTask::class)
            ->run(
                [
                    'name' => $request->get('name'),
                    'type' => $request->get('type'),
                    'game_id' => $request->getGameId(),
                ]
            );
    }
}
