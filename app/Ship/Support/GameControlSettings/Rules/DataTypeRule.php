<?php

namespace App\Ship\Support\GameControlSettings\Rules;

use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use App\Ship\Support\GameControlSettings\Layouts\Enums\DataTypesEnum;

final class DataTypeRule extends ValidateRule
{
    /**
     * @throws InvalidDataProvidedException
     */
    public function check(mixed $value)
    {
        switch ($this->value) {
            case DataTypesEnum::Bool->value:
                if (!in_array($value, [true, false, 1, 0, "true", "false", "1", "0"])) {
                    throw new InvalidDataProvidedException("The value must be boolean, string that contains boolean or integers 0, 1");
                }
                break;

            case DataTypesEnum::List->value:
                if (!is_array($value) || !array_is_list($value)) {
                    throw new InvalidDataProvidedException();
                }
                break;

            case DataTypesEnum::Numeric->value:
                if (!is_numeric($value)) {
                    throw new InvalidDataProvidedException("The value must be numerical");
                }
                break;

            case DataTypesEnum::Object->value:
                if (!is_array($value) || array_is_list($value)) {
                    throw new InvalidDataProvidedException("The value must be object");
                }
                break;

            case DataTypesEnum::String->value:
                if (!is_string($value)) {
                    throw new InvalidDataProvidedException("The value must be string");
                }
                break;

            default:
                throw new InvalidDataProvidedException("There is no such value type");
        }
    }
}
