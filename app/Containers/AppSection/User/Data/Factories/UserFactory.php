<?php

namespace App\Containers\AppSection\User\Data\Factories;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Factories\UserFactory as ParentUserFactory;

/**
 * @method User createOne($data = [])
 */
class UserFactory extends ParentUserFactory
{
    protected $model = User::class;
}
