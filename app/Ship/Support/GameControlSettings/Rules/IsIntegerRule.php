<?php

namespace App\Ship\Support\GameControlSettings\Rules;

use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;

final class IsIntegerRule extends ValidateRule
{
    /**
     * @throws InvalidDataProvidedException
     */
    public function check(mixed $value)
    {
        if ($this->value
            && (
                !is_numeric($value)
                || preg_match('/(\.)|(\s)|(,)|(e)/', $value)
            )
        ) {
            throw new InvalidDataProvidedException("The value must be integer");
        }
    }
}
