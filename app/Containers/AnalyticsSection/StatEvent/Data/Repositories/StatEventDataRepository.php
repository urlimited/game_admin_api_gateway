<?php

namespace App\Containers\AnalyticsSection\StatEvent\Data\Repositories;

use App\Containers\AnalyticsSection\StatEvent\Models\StatEventData;
use App\Ship\Parents\Repositories\Repository;

/**
 * @method StatEventData create(array $data)
 */
class StatEventDataRepository extends Repository
{
    protected $fieldSearchable = [
        'player_id'=>'=',
        'stat_event_id'=>'=',
        'value' => '=',
        'id' => '='
    ];

    public function model(): string
    {
        return StatEventData::class;
    }
}
