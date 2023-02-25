<?php

namespace App\Containers\GameManagementSection\User\Data\Factories;

use App\Containers\GameManagementSection\User\Models\User;
use App\Ship\Parents\Factories\UserFactory as ParentUserFactory;

/**
 * @method User createOne($data = [])
 */
class UserFactory extends ParentUserFactory
{
    protected $model = User::class;
}
