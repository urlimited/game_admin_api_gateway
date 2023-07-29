<?php

namespace App\Containers\AnalyticsSection\User\Data\Factories;

use App\Containers\AnalyticsSection\User\Models\User;
use App\Ship\Parents\Factories\UserFactory as ParentUserFactory;

class UserFactory extends ParentUserFactory
{
    protected $model = User::class;
}
