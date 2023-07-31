<?php

namespace App\Containers\AnalyticsSection\TargetGroup\Actions;

use App\Containers\AnalyticsSection\TargetGroup\Tasks\TargetGroupFilterTask;
use App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Requests\TargetGroupWebIndexRequest;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class TargetGroupIndexAction extends Action
{
    /**
     * @param TargetGroupWebIndexRequest $request
     * @return Collection
     */
    public function run(TargetGroupWebIndexRequest $request): Collection
    {
        return app(TargetGroupFilterTask::class)
            ->run(
                [
                    'game_id' => $request->getGameId()
                ]
            );
    }
}
