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
        try {
            switch ($this->value) {
                case DataTypesEnum::Bool->value:
                    if (!in_array($value, [true, false, 1, 0, "true", "false", "1", "0"])) {
                        throw new InvalidDataProvidedException();
                    }
                    break;

                case DataTypesEnum::List->value:
                    if (!is_array($value) || !array_is_list($value)) {
                        throw new InvalidDataProvidedException();
                    }
                    break;

                case DataTypesEnum::Numeric->value:
                    if (!is_numeric($value)) {
                        throw new InvalidDataProvidedException();
                    }
                    break;

                case DataTypesEnum::Object->value:
                    if (!is_array($value) || array_is_list($value)) {
                        throw new InvalidDataProvidedException();
                    }
                    break;

                case DataTypesEnum::String->value:
                    if (!is_string($value)) {
                        throw new InvalidDataProvidedException();
                    }
                    break;

                default:
                    throw new InvalidDataProvidedException();
            }
        } catch (\Exception $e) {
            dump($this->value);
            dd($value);
        }

    }
}
