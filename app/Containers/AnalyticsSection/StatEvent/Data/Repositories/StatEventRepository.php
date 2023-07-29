<?php

namespace App\Containers\AnalyticsSection\StatEvent\Data\Repositories;

use App\Containers\AnalyticsSection\StatEvent\Models\StatEvent;
use App\Ship\Parents\Repositories\Repository;

/**
 * @method StatEvent create(array $data)
 */
class StatEventRepository extends Repository
{
    protected $fieldSearchable = [
        'name'=>'=',
        'uuid'=>'=',
        'type' => '=',
        'id' => '='
    ];

    public function model(): string
    {
        return StatEvent::class;
    }
}
