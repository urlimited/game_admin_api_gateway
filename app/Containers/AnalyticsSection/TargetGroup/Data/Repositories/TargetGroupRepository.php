<?php

namespace App\Containers\AnalyticsSection\TargetGroup\Data\Repositories;

use App\Containers\AnalyticsSection\TargetGroup\Models\TargetGroup;
use App\Ship\Parents\Repositories\Repository;

/**
 * @method TargetGroup create(array $data)
 */
class TargetGroupRepository extends Repository
{
    protected $fieldSearchable = [
        'name'=>'=',
        'uuid'=>'=',
        'game_id' => '=',
        'id' => '='
    ];

    public function model(): string
    {
        return TargetGroup::class;
    }
}
