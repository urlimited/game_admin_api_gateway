<?php

namespace App\Ship\Support\GameControlSettings;

use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use App\Ship\Support\GameControlSettings\Layouts\LayoutSchemaValidator;
use App\Ship\Support\GameControlSettings\Settings\SettingSchemaValidator;

final class GameControlSettingsContext
{
    private ?array $layoutSchema = null;
    private ?array $settingSchema = null;
    private ?array $mixinSchema = null;

    public function __construct(
    )
    {

    }

    public function setSettingSchema(string $settingSchema)
    {
        $this->settingSchema = SettingSchemaValidator::process($settingSchema);
    }

    /**
     * @throws InvalidDataProvidedException
     */
    public function setLayoutSchema(array $settingSchema): void
    {
        $this->layoutSchema = LayoutSchemaValidator::process($settingSchema);
    }

    /**
     * @throws InvalidDataProvidedException
     */
    public function getSettingSchema(): array
    {
        if (is_null($this->settingSchema)) {
            throw new InvalidDataProvidedException();
        }

        return $this->settingSchema;
    }

    /**
     * @throws InvalidDataProvidedException
     */
    public function getLayoutSchema(): array
    {
        if (is_null($this->layoutSchema)) {
            throw new InvalidDataProvidedException();
        }

        return $this->layoutSchema;
    }
}
