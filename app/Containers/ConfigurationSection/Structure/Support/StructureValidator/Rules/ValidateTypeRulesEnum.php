<?php

namespace App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Rules;

enum ValidateTypeRulesEnum: string
{
    case InList = 'inList';
    case DataType = 'dataType';
    case RegExp = 'regExp';
    case Min = 'min';
    case Max = 'max';
    case Bool = 'bool';
}
