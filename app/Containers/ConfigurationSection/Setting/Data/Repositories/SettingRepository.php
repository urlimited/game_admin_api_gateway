<?php

namespace App\Containers\ConfigurationSection\Setting\Data\Repositories;
use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Ship\Parents\Repositories\Repository;

/**
 * @method Setting create(array $data)
 */
class SettingRepository extends Repository
{
    protected $fieldSearchable = [
        'game_id'=>'=',
        'layout_id'=>'=',
        'name' => '=',
        'author_id' => '=',
        'id' => '='
    ];

    public function model(): string
    {
        return Setting::class;
    }
}
