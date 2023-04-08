<?php

namespace App\Containers\ConfigurationSection\Structure\Support\StructureValidator;

use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Exceptions\InvalidDataProvidedForRuleException;
use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Rules\BoolRule;
use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Rules\DataTypeRule;
use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Rules\InListRule;
use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Rules\MaxRule;
use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Rules\MinRule;
use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Rules\RegExpRule;
use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Rules\ValidateRule;
use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Rules\ValidateTypeRulesEnum;
use Illuminate\Support\Collection;

final class StructureValidatorManager
{
    public static ?self $instance = null;

    private Collection $rules;

    private function __construct()
    {
        $this->rules = collect();
    }

    public static function init(): StructureValidatorManager
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * @throws InvalidDataProvidedForRuleException
     */
    public function addRule(array $ruleData): void
    {
        $this->checkAndFormatRuleDataStructure($ruleData);

        $dictionary = [
            ValidateTypeRulesEnum::RegExp->value => RegExpRule::class,
            ValidateTypeRulesEnum::DataType->value => DataTypeRule::class,
            ValidateTypeRulesEnum::InList->value => InListRule::class,
            ValidateTypeRulesEnum::Bool->value => BoolRule::class,
            ValidateTypeRulesEnum::Min->value => MinRule::class,
            ValidateTypeRulesEnum::Max->value => MaxRule::class,
        ];

        $this
            ->rules
            ->add(
                new $dictionary[$ruleData['type']->value](
                    value: $ruleData['value'],
                    targetId: $ruleData['targetId'],
                )
            );
    }


    public function formatToJSON(): string
    {
        $dictionary = [
            RegExpRule::class => ValidateTypeRulesEnum::RegExp->value,
            DataTypeRule::class => ValidateTypeRulesEnum::DataType->value,
            InListRule::class => ValidateTypeRulesEnum::InList->value,
            BoolRule::class => ValidateTypeRulesEnum::Bool->value,
            MinRule::class => ValidateTypeRulesEnum::Min->value,
            MaxRule::class => ValidateTypeRulesEnum::Max->value,
        ];

        return json_encode(
            $this
                ->rules
                ->map(
                    fn(ValidateRule $rule) => [
                        'targetId' => $rule->targetId,
                        'value' => $rule->value,
                        'type' => $dictionary[$rule::class],
                    ]
                )
                ->toArray()
        );
    }


    /**
     * @throws InvalidDataProvidedForRuleException
     */
    public function loadRulesFromJSON(string $jsonRules): void
    {
        $decodedJSON = json_decode($jsonRules, true);

        if (is_null($decodedJSON)) {
            throw new InvalidDataProvidedForRuleException('The JSON provided is not correct');
        }

        foreach ($decodedJSON as $ruleData) {
            $this->checkAndFormatRuleDataStructure($ruleData);

            $this->addRule($ruleData);
        }
    }


    /**
     * @throws InvalidDataProvidedForRuleException
     */
    private function checkAndFormatRuleDataStructure(array &$data): void
    {
        if (
            !array_key_exists('type', $data)
            || !array_key_exists('targetId', $data)
            || !array_key_exists('value', $data)
        ) {
            throw new InvalidDataProvidedForRuleException('The required key does not exist');
        }

        if (
            !($data['type'] instanceof ValidateTypeRulesEnum)
        ) {
            throw new InvalidDataProvidedForRuleException('The datatype is not correct');
        }
    }
}
