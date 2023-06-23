<?php

namespace App\Ship\Support\GameControlSettings\Layouts;

use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use App\Ship\Support\GameControlSettings\Rules\RulesInfo;
use Log;
use SplStack;

/**
 * @description The class responses for technical validation issues
 */
final class LayoutSchemaValidator
{
    /**
     * @throws InvalidDataProvidedException
     */
    public static function process(array $arrayLayoutSchema): array
    {
        foreach ($arrayLayoutSchema as $schema) {
            $stack = new SplStack();
            $stack->push($schema);

            while (!$stack->isEmpty()) {
                $current = $stack->pop();

                self::checkThatLayoutHasValidSchema($schema['content']);
                self::checkThatLayoutHasValidRules($schema['content']);

                if (!empty($current['children'] ?? [])) {
                    $stack->push($current['children']);
                }
            }
        }

        return $arrayLayoutSchema;
    }

    /**
     * @throws InvalidDataProvidedException
     */
    private static function checkThatLayoutHasValidSchema(array $currentLayoutSchema): void
    {
        if (
            !array_key_exists('name', $currentLayoutSchema)
            || !array_key_exists('rules', $currentLayoutSchema)
        ) {
            throw new InvalidDataProvidedException();
        }
    }

    /**
     * @throws InvalidDataProvidedException
     */
    private static function checkThatLayoutHasValidRules(array $currentLayoutSchema): void
    {
        $rules = collect($currentLayoutSchema['rules']);

        $rulesDictionary = RulesInfo::getRulesDictionary();

        $rules->each(
            function (array $rule) use ($rulesDictionary) {
                if (
                    !array_key_exists('type', $rule)
                    || !in_array($rule['type'], array_keys($rulesDictionary))
                ) {
                    throw new InvalidDataProvidedException();
                }
            }
        );
    }
}
