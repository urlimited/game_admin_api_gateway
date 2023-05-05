<?php

namespace App\Containers\ConfigurationSection\User\Data\Factories;

use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Factories\UserFactory as ParentUserFactory;

class UserFactory extends ParentUserFactory
{
    protected $model = User::class;
}
