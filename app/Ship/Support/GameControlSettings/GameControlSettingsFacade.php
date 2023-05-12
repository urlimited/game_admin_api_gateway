<?php

namespace App\Ship\Support\GameControlSettings;

use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use App\Ship\Support\GameControlSettings\Layouts\LayoutManager;
use App\Ship\Support\GameControlSettings\Settings\Exceptions\SettingNotInitializedException;
use App\Ship\Support\GameControlSettings\Settings\SettingManager;

final class GameControlSettingsFacade
{
    /**
     * @throws SettingNotInitializedException
     * @throws InvalidDataProvidedException
     */
    public static function checkSetting(GameControlSettingsContext $context): void
    {
        app(SettingManager::class)->init($context)->check();
    }

    public static function checkLayout(GameControlSettingsContext $context): void
    {
        app(LayoutManager::class)->init($context)->check();
    }

    public static function addSettingToContext(string $jsonSetting): void
    {

    }
}
