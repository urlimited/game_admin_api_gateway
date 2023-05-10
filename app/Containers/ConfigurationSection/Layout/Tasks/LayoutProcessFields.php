<?php

namespace App\Containers\ConfigurationSection\Layout\Tasks;

use App\Containers\ConfigurationSection\Layout\Data\Repositories\LayoutRepository;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Support\GameControlSettings\GameControlSettingsFacade;
use App\Ship\Support\GameControlSettings\Layouts\Enums\ValidateTypeRulesEnum;

class LayoutProcessFields extends Task
{
    public function __construct(
        protected LayoutRepository $repository
    )
    {
    }

    /**
     * @param array $fields
     * @return Layout
     * @throws \App\Containers\ConfigurationSection\Layout\Support\GameControlSettings\Layouts\Exceptions\InvalidDataProvidedException
     */
    public function run(array $fields): string
    {
        foreach ($fields as $field) {
            GameControlSettingsFacade::addRule(
                [
                    'type' => ValidateTypeRulesEnum::DataType,
                    'value' => $field['data_type'],
                    'targetId' => $field['path'],
                ]
            );

            if ($field['data_type'] === 'int' || $field['data_type'] === 'float') {
                if (!is_null($field['min'] ?? null)) {
                    GameControlSettingsFacade::addRule(
                        [
                            'type' => ValidateTypeRulesEnum::Min,
                            'value' => $field['min'],
                            'targetId' => $field['path'],
                        ]
                    );
                }

                if (!is_null($field['max'] ?? null)) {
                    GameControlSettingsFacade::addRule(
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
                    GameControlSettingsFacade::addRule(
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
                    GameControlSettingsFacade::addRule(
                        [
                            'type' => ValidateTypeRulesEnum::InList,
                            'value' => $field['list_values'],
                            'targetId' => $field['path'],
                        ]
                    );
                }
            }
        }

        return GameControlSettingsFacade::formatToJSON();
    }
}
