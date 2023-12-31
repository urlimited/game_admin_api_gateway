<?php

namespace App\Ship\Support\GameControlSettings\Rules;

use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;

final class MaxRule extends ValidateRule
{
    /**
     * @throws InvalidDataProvidedException
     */
    public function check(mixed $value)
    {
        if ($this->value < $value) {
            throw new InvalidDataProvidedException("The value doesn't match max rule, must be less or equal than: $this->value");
        }
    }
}
