<?php

namespace App\Containers\AnalyticsSection\TargetGroup\Actions;


use App\Containers\AnalyticsSection\TargetGroup\Models\TargetGroup;
use App\Containers\AnalyticsSection\TargetGroup\Tasks\TargetGroupDeleteTask;
use App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Requests\TargetGroupWebDeleteRequest;
use App\Ship\Parents\Actions\Action;

class TargetGroupDeleteAction extends Action
{
    /**
     * @param TargetGroupWebDeleteRequest $request
     * @param TargetGroup $targetGroup
     * @return void
     */
    public function run(TargetGroupWebDeleteRequest $request, TargetGroup $targetGroup): void
    {
        app(TargetGroupDeleteTask::class)->run($targetGroup->getAttribute('id'));
    }
}
