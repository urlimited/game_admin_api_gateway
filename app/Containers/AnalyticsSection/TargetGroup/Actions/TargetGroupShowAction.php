<?php

namespace App\Containers\AnalyticsSection\TargetGroup\Actions;

use App\Containers\AnalyticsSection\TargetGroup\Models\TargetGroup;
use App\Containers\AnalyticsSection\TargetGroup\Tasks\TargetGroupFilterTask;
use App\Ship\Parents\Actions\Action;

class TargetGroupShowAction extends Action
{
    /**
     * @param TargetGroup $targetGroup
     * @return TargetGroup|null
     */
    public function run(TargetGroup $targetGroup): ?TargetGroup
    {
        $targetGroup = app(TargetGroupFilterTask::class)
            ->run(
                [
                    'id' => $targetGroup->getAttribute('id'),
                ],
            );

        return $targetGroup->isNotEmpty() ? $targetGroup->first() : null;
    }
}
