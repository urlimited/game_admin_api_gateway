<?php

namespace App\Containers\ConfigurationSection\Structure\Data\Repositories;

use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Ship\Parents\Repositories\Repository;

/**
 * @method Structure create(array $data)
 */
class StructureRepository extends Repository
{
    protected $fieldSearchable = [
        'game_id' => '=',
        'name' => '=',
        'id' => '='
    ];

    public function model(): string
    {
        return Structure::class;
    }
}
