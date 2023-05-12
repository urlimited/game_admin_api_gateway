<?php

namespace App\Ship\Support\GameControlSettings\Tests;

use App\Ship\Parents\Tests\PhpUnit\TestCase;
use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use App\Ship\Support\GameControlSettings\GameControlSettingsContext;
use App\Ship\Support\GameControlSettings\GameControlSettingsFacade;
use App\Ship\Support\GameControlSettings\Settings\Exceptions\SettingNotInitializedException;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

class CheckSettingTest extends TestCase
{
    /**
     * @throws FileNotFoundException
     * @throws InvalidDataProvidedException
     * @throws SettingNotInitializedException
     */
    public function testCorrectSettingSchema()
    {
        $this->expectNotToPerformAssertions();

        $layoutSchema = File::get(__DIR__ . '/Stubs/validLayout.json');
        $settingSchema = File::get(__DIR__ . '/Stubs/validSettingOnValidLayout.json');

        $context = new GameControlSettingsContext();
        $context->setLayoutSchema(json_decode($layoutSchema, true));
        $context->setSettingSchema(json_decode($settingSchema, true));

        GameControlSettingsFacade::checkSetting($context);
    }

    /**
     * @throws FileNotFoundException
     * @throws InvalidDataProvidedException
     */
    public function testErrorSettingSchema()
    {
        $layoutSchema = File::get(__DIR__ . '/Stubs/validLayout.json');

        foreach(
            [
                '/Stubs/incorrectRequiredStringSettingOnValidLayout.json',
                '/Stubs/incorrectDataTypeObjectSettingOnValidLayout.json',
                '/Stubs/incorrectMinSettingOnValidLayout.json',
                '/Stubs/incorrectMaxSettingOnValidLayout.json',
                '/Stubs/incorrectRegexSettingOnValidLayout.json',
            ] as $settingSchemaPath
        ) {
            $settingSchema = File::get(__DIR__ . $settingSchemaPath);

            $context = new GameControlSettingsContext();
            $context->setLayoutSchema(json_decode($layoutSchema, true));
            $context->setSettingSchema(json_decode($settingSchema, true));

            try {
                GameControlSettingsFacade::checkSetting($context);

                self::fail('No exceptions are caught');
            } catch (Exception $e) {
                $this->assertEquals(InvalidDataProvidedException::class, $e::class);
            }
        }
    }
}
