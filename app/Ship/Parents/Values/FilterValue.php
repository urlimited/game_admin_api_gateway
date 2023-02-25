<?php

namespace App\Ship\Parents\Values;

final class FilterValue extends Value
{
    public function __construct(
        public readonly string $key,
        public readonly string $operator,
        public readonly mixed $value,
    ){}
}
