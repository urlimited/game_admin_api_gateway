<?php

namespace App\Ship\Support\GameControlSettings\Layouts;

use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use App\Ship\Support\GameControlSettings\GameControlSettingsContext;

/**
 * @description The class responses for logical validation issues
 */
final class LayoutManager
{
    private bool $isInitialized = false;
    private array $layoutSchema;

    /**
     * @throws InvalidDataProvidedException
     */
    public function init(GameControlSettingsContext $context): LayoutManager
    {
        if ($this->isInitialized) {
            return $this;
        }

        $this->layoutSchema = $context->getLayoutSchema();

        $this->isInitialized = true;

        return $this;
    }

    public function check(): void
    {

    }
}
