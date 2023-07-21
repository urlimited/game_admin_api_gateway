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
        // Escape regexp format
        if (
            $this->value[0] === '/'
            && (
                $this->value[strlen($this->value) - 1] === '/'
                || $this->value[strlen($this->value) - 2] === '/'
                || $this->value[strlen($this->value) - 3] === '/'
                || $this->value[strlen($this->value) - 4] === '/'
            )
        ) {
            if (!preg_match($this->value, $value)) {
                throw new InvalidDataProvidedException("The value doesn\'t match regular expression: $this->value");
            }
        } else {
            if (!preg_match('/' . $this->value . '/', $value)) {
                throw new InvalidDataProvidedException("The value doesn\'t match regular expression: $this->value");
            }
        }
    }
}
