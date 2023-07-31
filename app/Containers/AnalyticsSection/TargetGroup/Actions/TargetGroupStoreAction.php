<?php

namespace App\Containers\AnalyticsSection\TargetGroup\Actions;


use App\Containers\AnalyticsSection\TargetGroup\Models\TargetGroup;
use App\Containers\AnalyticsSection\TargetGroup\Tasks\TargetGroupStoreTask;
use App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Requests\TargetGroupWebStoreRequest;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;

class TargetGroupStoreAction extends Action
{
    /**
     * @param TargetGroupWebStoreRequest $request
     * @return void
     * @throws ValidatorException
     */
    public function run(TargetGroupWebStoreRequest $request): void
    {
        app(TargetGroupStoreTask::class)
            ->run(
                [
                    'game_id' => $request->getGameId(),
                    'conditions' => $request->get('conditions'),
                    'name' => $request->get('name'),
                ]
            );
    }
}
