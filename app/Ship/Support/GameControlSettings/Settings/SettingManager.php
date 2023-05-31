<?php

namespace App\Ship\Support\GameControlSettings\Settings;

use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use App\Ship\Support\GameControlSettings\GameControlSettingsContext;
use App\Ship\Support\GameControlSettings\Rules\RulesInfo;
use App\Ship\Support\GameControlSettings\Rules\ValidateRule;
use App\Ship\Support\GameControlSettings\Settings\Exceptions\SettingNotInitializedException;
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
     * @throws InvalidDataProvidedException
     */
    public function init(GameControlSettingsContext $context): SettingManager
    {
        if ($this->isInitialized) {
            return $this;
        }

        $this->settingPathMaps = $this->processSettingPathMapsFromTree($context->getLayoutSchema());

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
            $settingValue = $this->setting;

            while($settingPaths->isNotEmpty()) {
                $queuedValue = $settingPaths->shift();

                // The main idea is just to replace all asterisks with array indexes
                if ($queuedValue == '*') {
                    // At the moment setting value contains a parent value of a current
                    if (!is_array($settingValue) || !array_is_list($settingValue)) {
                        throw new InvalidDataProvidedException();
                    }

                    $lastIndex = count($settingValue);

                    $pos = strpos($pathToSetting, '*');

                    for ($i = 0; $i < $lastIndex; $i++) {
                        $allSettingsQueue->put(
                            substr_replace($pathToSetting, (string)$i, $pos, 1),
                            $rules
                        );
                    }

                    continue 2;
                } else {
                    $settingValue = $settingValue[$queuedValue] ?? null;
                }
            }

            $rules->each(
                fn(ValidateRule $rule) => $rule->check($settingValue)
            );
        }
    }

    private function processSettingPathMapsFromTree(array $treeLayout): Collection
    {
        $tree = TreeBuilder::fromArray(['children' => $treeLayout]);

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
