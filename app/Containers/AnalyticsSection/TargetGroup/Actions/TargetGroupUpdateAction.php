<?php

namespace App\Containers\AnalyticsSection\TargetGroup\Actions;


use App\Containers\AnalyticsSection\TargetGroup\Models\TargetGroup;
use App\Containers\AnalyticsSection\TargetGroup\Tasks\TargetGroupUpdateTask;
use App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Requests\TargetGroupWebUpdateRequest;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;

class TargetGroupUpdateAction extends Action
{
    /**
     * @param TargetGroupWebUPdateRequest $request
     * @param TargetGroup $targetGroup
     * @return void
     * @throws ValidatorException
     */
    public function run(TargetGroupWebUpdateRequest $request, TargetGroup $targetGroup): void
    {
        app(TargetGroupUpdateTask::class)
            ->run(
                $targetGroup->getAttribute('id'),
                [
                    'conditions' => $request->get('conditions'),
                    'name' => $request->get('name'),
                ]
            );
    }
}
