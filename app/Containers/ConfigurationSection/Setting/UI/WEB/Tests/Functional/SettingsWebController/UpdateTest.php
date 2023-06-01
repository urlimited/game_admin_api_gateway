<?php

namespace App\Containers\ConfigurationSection\Setting\UI\WEB\Tests\Functional\SettingsWebController;


use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Containers\ConfigurationSection\Setting\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Models\Permission;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;
use Illuminate\Support\Facades\File;

/**
 * @desription Successfully update setting \
 *      Covered scenarios: \
 *          1. Successfully update setting \
 *          2. Fails to update setting with invalid data
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Setting\UI\WEB\Controllers\SettingsWebController::update
 */
class UpdateTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyUpdateSetting(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $user = $this->asCommonCustomer(User::factory()
            ->hasAttached($game)
        )->createOne();

        $layout = Layout::factory()
            ->for($game)
            ->createOne();

        $setting = Setting::factory()
            ->for($layout)
            ->for($game)
            ->createOne();

        $json = File::get(__DIR__ . '/../../Stubs/CorrectSetting.json');

        $array = json_decode($json, true);

        // 2. Scenario run
        $data = [
            'name' => 'rerum',
            'schema' => $array,
        ];


        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('put',
                route('api.private.games.settings.update',
                    [
                        'setting' => $setting->getAttribute('uuidText'),
                    ]
                ),
                $data,
            );

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'uuid',
                    'name',
                    'layout_uuid',
                    'schema',
                ]
            ]
        );
    }

    public function testFailsToUpdateInvalidSettingData(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $user = $this->asCommonCustomer(User::factory()
            ->hasAttached($game)
        )->createOne();

        $layout = Layout::factory()
            ->for($game)
            ->createOne();

        $setting = Setting::factory()
            ->for($layout)
            ->for($game)
            ->createOne();

        $json = File::get(__DIR__ . '/../../Stubs/InvalidSetting.json');

        $array = json_decode($json, true);

        // 2. Scenario run
        $data = [
            'name' => 'rerum',
            'schema' => $array,
        ];


        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('put',
                route('api.private.games.settings.update',
                    [
                        'setting' => $setting->getAttribute('uuidText'),
                    ]
                ),
                $data,
            );

        $response->assertStatus(422);
    }
}
