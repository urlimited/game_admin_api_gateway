<?php

namespace App\Ship\Support\GameControlSettings\Rules;

use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;

final class RegExpRule extends ValidateRule
{
    /**
     * @throws InvalidDataProvidedException
     */
    public function check(mixed $value)
    {
        if (preg_match('/' . $this->value . '/', $value)) {
            throw new InvalidDataProvidedException();
        }
    }
}
