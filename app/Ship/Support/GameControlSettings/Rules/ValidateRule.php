<?php

namespace App\Ship\Support\GameControlSettings\Rules;

use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;

abstract class ValidateRule
{
    public string $type;
    public string $value;

    /**
     * @throws \App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException
     */
    public function __construct(array $data){
        if (
            !array_key_exists('type', $data)
            || !array_key_exists('value', $data)
        ) {
            throw new InvalidDataProvidedException();
        }

        $this->type = $data['type'];
        $this->value = $data['value'];
    }

    abstract public function check(mixed $value);
}
