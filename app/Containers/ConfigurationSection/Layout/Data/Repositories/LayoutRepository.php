<?php

namespace App\Containers\ConfigurationSection\Layout\Data\Repositories;

use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Ship\Parents\Repositories\Repository;

/**
 * @method Layout create(array $data)
 */
class LayoutRepository extends Repository
{
    protected $fieldSearchable = [
        'game_id' => '=',
        'name' => '=',
        'id' => '='
    ];

    public function model(): string
    {
        return Layout::class;
    }
}
