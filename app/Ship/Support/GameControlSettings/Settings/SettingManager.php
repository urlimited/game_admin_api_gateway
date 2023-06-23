<?php

namespace App\Ship\Support\GameControlSettings\Settings;

use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use App\Ship\Support\GameControlSettings\GameControlSettingsContext;
use App\Ship\Support\GameControlSettings\Rules\RulesInfo;
use App\Ship\Support\GameControlSettings\Rules\ValidateRule;
use App\Ship\Support\GameControlSettings\Settings\Exceptions\SettingNotInitializedException;
use CodeBaseTeam\DataStructures\Tree\Exceptions\InvalidDataException;
use CodeBaseTeam\DataStructures\Tree\TreeBuilder;
use CodeBaseTeam\DataStructures\Tree\TreeNode;
use Illuminate\Support\Collection;


/**
 * @description The class responses for logical validation issues
 */
class SettingManager
{
    private Collection $settingPathMaps;
    private bool $isInitialized = false;
    private array $setting;

    /**
     * @param GameControlSettingsContext $context
     * @return SettingManager
     * @throws InvalidDataException
     * @throws InvalidDataProvidedException
     */
    public function init(GameControlSettingsContext $context): SettingManager
    {
        if ($this->isInitialized) {
            return $this;
        }

        $layoutSchema = $context->getLayoutSchema();

        if (!empty($layoutSchema)) {
            $this->settingPathMaps = $this->processSettingPathMapsFromTree($layoutSchema);
        } else {
            $this->settingPathMaps = collect();
        }

        $this->setting = $context->getSettingSchema();
        $this->isInitialized = true;

        return $this;
    }

    /**
     * @throws SettingNotInitializedException
     * @throws InvalidDataProvidedException
     */
    public function check(): void
    {
        if (!$this->isInitialized) {
            throw new SettingNotInitializedException();
        }

        $allSettingsQueue = $this->settingPathMaps;

        while ($allSettingsQueue->isNotEmpty()) {
            $pathToSetting = $allSettingsQueue->keys()->first();
            $rules = $allSettingsQueue->shift();

            $settingPaths = collect(explode('/', $pathToSetting));
            $settingValue = [SettingSchemaValidator::VISIBLE_FIELDS => $this->setting];

            while($settingPaths->isNotEmpty()) {
                $queuedValue = $settingPaths->shift();

                // The main idea is just to replace all asterisks with array indexes
                if ($queuedValue == '*') {
                    // At the moment setting value contains a parent value of a current
                    if (
                        !is_array($settingValue[SettingSchemaValidator::VISIBLE_FIELDS])
                        || !array_is_list($settingValue[SettingSchemaValidator::VISIBLE_FIELDS])
                    ) {
                        throw new InvalidDataProvidedException();
                    }

                    $lastIndex = count($settingValue[SettingSchemaValidator::VISIBLE_FIELDS]);

                    $pos = strpos($pathToSetting, '*');

                    for ($i = 0; $i < $lastIndex; $i++) {
                        $allSettingsQueue->put(
                            substr_replace($pathToSetting, (string)$i, $pos, 1),
                            $rules
                        );
                    }

                    continue 2;
                } else {
                    $settingValue = $settingValue[SettingSchemaValidator::VISIBLE_FIELDS][$queuedValue] ?? null;
                }
            }

            $rules->each(
                fn(ValidateRule $rule) => $rule->check($settingValue[SettingSchemaValidator::VISIBLE_FIELDS])
            );
        }
    }

    /**
     * @throws InvalidDataException
     */
    private function processSettingPathMapsFromTree(array $treeLayout): Collection
    {
        TreeBuilder::setValueContentFieldKey('content');
        TreeBuilder::setMetaFieldKeys(['id', 'meta']);
        TreeBuilder::setChildrenFieldKey('children');

        $tree = TreeBuilder::fromArray(
            [
                'content' => [
                    'children' => $treeLayout
                ],
            ]
        );

        $result = collect();

        $tree->traversalPreOrder(
            node: $tree->getRoot(),
            callback: function (TreeNode $node) use ($result) {
                $name = $node->getValue()['name'] ?? '';

                $parent = $node->getParent();

                while (!is_null($parent)) {
                    if (empty($parent->getValue())) {
                        $parent = $parent->getParent();

                        continue;
                    }

                    $name = $parent->getValue()['name'] . '/' . $name;

                    $parent = $parent->getParent();
                }

                $result->put($name, $this->processRules($node->getValue()['rules'] ?? []));
            }
        );

        // Skip root element
        $result->shift();

        return $result;
    }

    private function processRules(array $rules): Collection
    {
        $rulesDictionary = RulesInfo::getRulesDictionary();

        return collect($rules)
            ->map(
                fn(array $rule) => new $rulesDictionary[$rule['type']](
                    [
                        'type' => $rule['type'],
                        'value' => $rule['value']
                    ]
                )
            );
    }
}
