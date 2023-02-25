<?php

namespace App\Containers\AppSection\User\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class UserRepository extends Repository
{
    protected $fieldSearchable = [
        'login' => '=',
        'id' => '='
    ];

    public function model(): string
    {
        return config('auth.providers.users.model');
    }
}
