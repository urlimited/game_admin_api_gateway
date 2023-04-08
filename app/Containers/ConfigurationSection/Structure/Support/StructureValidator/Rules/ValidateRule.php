<?php

namespace App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Rules;

abstract class ValidateRule
{
    public function __construct(
        public mixed $value,
        public mixed  $targetId,
    )
    {
    }
}
