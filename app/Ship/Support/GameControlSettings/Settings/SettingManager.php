<?php

namespace App\Ship\Support\GameControlSettings\Settings;

use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use App\Ship\Support\GameControlSettings\GameControlSettingsContext;
use App\Ship\Support\GameControlSettings\Rules\RulesInfo;
use App\Ship\Support\GameControlSettings\Rules\ValidateRule;
use App\Ship\Support\GameControlSettings\Settings\Exceptions\SettingNotInitializedException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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

                while (empty($settingPaths)) {
                    $settingValue = $settingValue[$settingPaths->pop()];
                }

                $rules->each(
                    fn(ValidateRule $rule) => $rule->check($settingValue)
                );
            }
        );
    }

    private function processSettingPathMapsFromTree(array $treeLayout): Collection
    {
        $stack = collect($treeLayout);
        $result = collect();

        while (!$stack->isEmpty()) {
            $path = substr(
                $stack
                    ->reduce(fn(string $accum, array $next) => $accum . '/' . $next['name'] ?? '', ''),
                1
            );

            $current = $stack->pop();

            $result->put($path, $this->processRules(collect($current['rules'])));

            if (!empty($current['children'] ?? [])) {
                $stack->push(...$current['children']);
            }
        }

        return $result;
    }

    private function processRules(Collection $rules): Collection
    {
        $rulesDictionary = RulesInfo::getRulesDictionary();

        return $rules
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
