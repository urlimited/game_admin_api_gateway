<?php

namespace App\Ship\Support\GameControlSettings\Layouts\Enums;

enum ValidateTypeRulesEnum: string
{
    case InList = 'inList';
    case DataType = 'dataType';
    case RegExp = 'regex';
    case Min = 'min';
    case Max = 'max';
    case IsInteger = 'isInteger';
    case IsRequired = 'isRequired';
}
