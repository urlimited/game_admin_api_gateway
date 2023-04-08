<?php

namespace App\Containers\ConfigurationSection\Structure\Support\StructureValidator;

use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Exceptions\InvalidDataProvidedForRuleException;

class StructureValidatorFacade
{
    public static function formatToJSON(): string
    {
        return StructureValidatorManager::init()->formatToJSON();
    }

    /**
     * @throws InvalidDataProvidedForRuleException
     */
    public static function addRule(array $rule): void
    {
        StructureValidatorManager::init()->addRule($rule);
    }

    /**
     * @throws InvalidDataProvidedForRuleException
     */
    public static function loadFromJSON(string $jsonString): void
    {
        StructureValidatorManager::init()->loadRulesFromJSON($jsonString);
    }
}
