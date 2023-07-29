<?php

namespace App\Containers\AnalyticsSection\StatEvent\Actions;


use App\Containers\AnalyticsSection\StatEvent\Models\StatEvent;
use App\Containers\AnalyticsSection\StatEvent\Tasks\StatEventDataStoreTask;
use App\Containers\AnalyticsSection\StatEvent\UI\Contracts\Requests\StatEventDataStoreRequestContract;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;
use Ramsey\Uuid\Uuid;

class StatEventDataStoreAction extends Action
{
    /**
     * @param StatEventDataStoreRequestContract $request
     * @return void
     * @throws ValidatorException
     */
    public function run(StatEventDataStoreRequestContract $request): void
    {
        foreach ($request->get('stat_event_data') as $statEventDataItem) {
            $statEventId = StatEvent::query()
                ->where('uuid', Uuid::fromString($statEventDataItem['stat_event_uuid'])->getBytes())
                ->first()
                ->getAttribute('id');

            // @todo(mt) N+1 problem
            app(StatEventDataStoreTask::class)
                ->run(
                    [
                        'player_id' => $request->getPlayerId(),
                        'stat_event_id' => $statEventId,
                        'value' => $statEventDataItem['value'],
                    ]
                );
        }
    }
}
