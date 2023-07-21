<?php

namespace App\Ship\Support\GameControlSettings\Rules;

use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;

final class MinRule extends ValidateRule
{
    /**
     * @throws InvalidDataProvidedException
     */
    public function check(mixed $value)
    {
        if ($this->value > $value) {
            throw new InvalidDataProvidedException("The value doesn't match min rule, must be more or equal than: $this->value");
        }
    }
}
