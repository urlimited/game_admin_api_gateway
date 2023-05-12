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
            case DataTypesEnum::Bool:
                if (!in_array($value, [true, false, 1, 0, "true", "false", "1", "0"])) {
                    throw new InvalidDataProvidedException();
                }
                break;

            case DataTypesEnum::List:
                if (!is_array($value) || !array_is_list($value)) {
                    throw new InvalidDataProvidedException();
                }
                break;

            case DataTypesEnum::Numeric:
                if (!is_numeric($value)) {
                    throw new InvalidDataProvidedException();
                }
                break;

            case DataTypesEnum::Object:
                if (!is_array($value) || array_is_list($value)) {
                    throw new InvalidDataProvidedException();
                }
                break;

            case DataTypesEnum::String:
                if (!is_string($value)) {
                    throw new InvalidDataProvidedException();
                }
                break;

            default:
                throw new InvalidDataProvidedException();
        }
    }
}
