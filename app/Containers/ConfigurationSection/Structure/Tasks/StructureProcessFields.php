<?php

namespace App\Containers\ConfigurationSection\Structure\Tasks;

use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Data\Repositories\StructureRepository;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Exceptions\InvalidDataProvidedForRuleException;
use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Rules\ValidateTypeRulesEnum;
use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\StructureValidatorFacade;
use App\Ship\Parents\Tasks\Task;

class StructureProcessFields extends Task
{
    public function __construct(
        protected StructureRepository $repository
    )
    {
    }

    /**
     * @param array $fields
     * @return Structure
     * @throws InvalidDataProvidedForRuleException
     */
    public function run(array $fields): string
    {
        foreach ($fields as $field) {
            StructureValidatorFacade::addRule(
                [
                    'type' => ValidateTypeRulesEnum::DataType,
                    'value' => $field['data_type'],
                    'targetId' => $field['path'],
                ]
            );

            if ($field['data_type'] === 'int' || $field['data_type'] === 'float') {
                if (!is_null($field['min'] ?? null)) {
                    StructureValidatorFacade::addRule(
                        [
                            'type' => ValidateTypeRulesEnum::Min,
                            'value' => $field['min'],
                            'targetId' => $field['path'],
                        ]
                    );
                }

                if (!is_null($field['max'] ?? null)) {
                    StructureValidatorFacade::addRule(
                        [
                            'type' => ValidateTypeRulesEnum::Max,
                            'value' => $field['max'],
                            'targetId' => $field['path'],
                        ]
                    );
                }
            }

            if ($field['data_type'] === 'string') {
                if (!is_null($field['regex'] ?? null)) {
                    StructureValidatorFacade::addRule(
                        [
                            'type' => ValidateTypeRulesEnum::RegExp,
                            'value' => $field['regex'],
                            'targetId' => $field['path'],
                        ]
                    );
                }
            }

            if ($field['data_type'] === 'list_values') {
                if (!is_null($field['list_values'] ?? null)) {
                    StructureValidatorFacade::addRule(
                        [
                            'type' => ValidateTypeRulesEnum::InList,
                            'value' => $field['list_values'],
                            'targetId' => $field['path'],
                        ]
                    );
                }
            }
        }

        return StructureValidatorFacade::formatToJSON();
    }
}
