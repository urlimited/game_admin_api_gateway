<?php

namespace App\Containers\ConfigurationSection\Configuration\Data\Repositories;
use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Ship\Parents\Repositories\Repository;

/**
 * @method Configuration create(array $data)
 */
class ConfigurationRepository extends Repository
{
    protected $fieldSearchable = [
        'game_id'=>'=',
        'structure_id'=>'=',
        'name' => '=',
        'author_id' => '=',
        'id' => '='
    ];

    public function model(): string
    {
        return Configuration::class;
    }
}
