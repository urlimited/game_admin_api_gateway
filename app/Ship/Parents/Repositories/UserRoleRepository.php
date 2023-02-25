<?php

namespace App\Ship\Parents\Repositories;

abstract class UserRoleRepository extends Repository
{
    protected $fieldSearchable = [
        'name' => '=',
        'display_name' => 'like',
        'description' => 'like',
    ];
}
