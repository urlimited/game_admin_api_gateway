<?php

namespace App\Containers\AppSection\User\Enums;

enum UserStatus: string
{
    case Active = 'active';
    case OnCheck = 'on_check';
    case Blocked = 'blocked';
}
