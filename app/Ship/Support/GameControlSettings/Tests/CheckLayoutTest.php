<?php

namespace App\Ship\Support\GameControlSettings\Tests;

use App\Ship\Parents\Tests\PhpUnit\TestCase;
use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use App\Ship\Support\GameControlSettings\GameControlSettingsContext;
use App\Ship\Support\GameControlSettings\GameControlSettingsFacade;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

class CheckLayoutTest extends TestCase
{
    /**
     * @throws FileNotFoundException
     * @throws InvalidDataProvidedException
     */
    public function testCorrectLayoutSchema()
    {
        $layoutSchema = File::get(__DIR__ . '/Stubs/validLayout.json');

        $context = new GameControlSettingsContext();
        $context->setLayoutSchema(json_decode($layoutSchema, true));

        GameControlSettingsFacade::checkLayout($context);
    }
}
