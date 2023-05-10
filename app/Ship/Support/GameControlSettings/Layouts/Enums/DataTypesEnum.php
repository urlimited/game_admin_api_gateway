<?php

namespace App\Ship\Support\GameControlSettings\Layouts\Enums;

enum DataTypesEnum: string
{
    case Bool = 'bool';
    case List = 'list';
    case Object = 'object';
    case Numeric = 'numeric';
    case String = 'string';
}
