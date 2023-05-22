<?php

namespace App\Ship\Support\GameControlSettings;

use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use App\Ship\Support\GameControlSettings\Layouts\LayoutManager;
use App\Ship\Support\GameControlSettings\Settings\Exceptions\SettingNotInitializedException;
use App\Ship\Support\GameControlSettings\Settings\SettingManager;
use CodeBaseTeam\DataStructures\Tree\Exceptions\InvalidDataException;

final class GameControlSettingsFacade
{
    /**
     * @throws SettingNotInitializedException
     * @throws InvalidDataProvidedException
     * @throws InvalidDataException
     */
    public static function checkSetting(GameControlSettingsContext $context): void
    {
        app(SettingManager::class)->init($context)->check();
    }

    /**
     * @throws InvalidDataProvidedException
     */
    public static function checkLayout(GameControlSettingsContext $context): void
    {
        app(LayoutManager::class)->init($context)->check();
    }

    public static function addSettingToContext(string $jsonSetting): void
    {

    }
}
