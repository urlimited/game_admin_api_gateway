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
     * @throws InvalidDataProvidedException
     */
    public function init(GameControlSettingsContext $context): SettingManager
    {
        if ($this->isInitialized) {
            return $this;
        }

        $this->settingPathMaps = $this->processSettingPathMapsFromTree($context->getLayoutSchema());

        $this->setting = $context->getSettingSchema();
dd($this->settingPathMaps);
        $this->isInitialized = true;

        return $this;
    }

    /**
     * @throws SettingNotInitializedException
     */
    public function check(): void
    {
        if (!$this->isInitialized) {
            throw new SettingNotInitializedException();
        }

        $this->settingPathMaps->each(
            function (Collection $rules, string $pathToSetting) {
                $settingPaths = collect(explode('/', $pathToSetting));
                $settingValue = $this->setting;

                while ($settingPaths->isNotEmpty()) {
                    $poppedValue = $settingPaths->pop();

                    if ($poppedValue == '*') {
                        // @todo(mt) need to be processed with recursion each element of setting
                    }

                    $settingValue = $settingValue[$poppedValue] ?? null;
                }

                $rules->each(
                    fn(ValidateRule $rule) => $rule->check($settingValue)
                );
            }
        );
    }

    private function processSettingPathMapsFromTree(array $treeLayout): Collection
    {
        $tree = TreeBuilder::fromArray(['children' => $treeLayout]);

        $result = collect();

        $tree->traversalPreOrder(
            node: $tree->getRoot(),
            callback: function(TreeNode $node) use ($result) {
                $name = $node->getValue()['name'] ?? '';

                $parent = $node->getParent();

                while(!is_null($parent)) {
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
