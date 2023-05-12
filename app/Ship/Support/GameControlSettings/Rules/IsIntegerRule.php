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
                || preg_match('/(\.)|(\d)|(,)|(e)/', $value)
            )
        ) {
            throw new InvalidDataProvidedException();
        }
    }
}
