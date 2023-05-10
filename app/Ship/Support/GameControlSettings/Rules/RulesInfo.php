<?php

namespace App\Ship\Support\GameControlSettings\Rules;

use App\Ship\Support\GameControlSettings\Layouts\Enums\ValidateTypeRulesEnum;

abstract class RulesInfo
{
    public static function getRulesDictionary(): array
    {
        return array(
            ValidateTypeRulesEnum::InList->value => InListRule::class,
            ValidateTypeRulesEnum::DataType->value => DataTypeRule::class,
            ValidateTypeRulesEnum::Max->value => MaxRule::class,
            ValidateTypeRulesEnum::Min->value => MinRule::class,
            ValidateTypeRulesEnum::RegExp->value => RegExpRule::class,
            ValidateTypeRulesEnum::IsInteger->value => IsIntegerRule::class,
            ValidateTypeRulesEnum::IsRequired->value => IsRequiredRule::class,
        );
    }
}
