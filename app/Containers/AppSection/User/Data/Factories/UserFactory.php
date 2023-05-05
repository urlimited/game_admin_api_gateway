<?php

namespace App\Containers\AppSection\User\Data\Factories;

use App\Ship\Parents\Factories\UserFactory as ParentUserFactory;
use App\Ship\Parents\Models\User;

/**
 * @method User createOne($data = [])
 */
class UserFactory extends ParentUserFactory
{
    protected $model = User::class;
}
