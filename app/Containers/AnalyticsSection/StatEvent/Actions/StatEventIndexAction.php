<?php

namespace App\Containers\AnalyticsSection\StatEvent\Actions;

use App\Containers\AnalyticsSection\StatEvent\Tasks\StatEventFilterTask;
use App\Containers\AnalyticsSection\StatEvent\UI\WEB\Requests\StatEventWebIndexRequest;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class StatEventIndexAction extends Action
{
    /**
     * @param StatEventWebIndexRequest $request
     * @return Collection
     */
    public function run(StatEventWebIndexRequest $request): Collection
    {
        return app(StatEventFilterTask::class)
            ->run(
                [
                    'game_id' => $request->getGameId()
                ]
            );
    }
}
