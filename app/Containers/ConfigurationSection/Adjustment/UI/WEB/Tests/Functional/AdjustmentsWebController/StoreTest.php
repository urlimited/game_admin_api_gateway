<?php

namespace App\Containers\ConfigurationSection\Adjustment\UI\WEB\Tests\Functional\AdjustmentsWebController;

use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Containers\ConfigurationSection\Layout\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription test creates a new adjustment on the given setting \
 *  Covered scenarios: \
 *      1. Successfully store adjustment for the setting without layout \
 *      2. Successfully store correct adjustment for the setting with layout \
 *      3. Fails to create adjustment with incorrect fields according to the layout
 * @group adjustment
 * @group internal.api
 * @covers \App\Containers\ConfigurationSection\Adjustment\UI\WEB\Controllers\AdjustmentsWebController::store
 */
class StoreTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyStoreSetting(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $actor = $this->asCommonCustomer(User::factory())
            ->hasAttached($game)
            ->createOne();

        $setting = Setting::factory()
            ->for($game)
            ->createOne();

        $json = '{
            "type": "add",
            "content": {
                "maps": [
                    {
                        "name": "dust_updated",
                        "width": 1300,
                        "height": 1200
                    }
                ],
                "players": [
                    {
                        "name": "Carl",
                        "rank": "global"
                    }
                ]
            }
        }';

        $array = json_decode($json, true);

        // 2. Scenario run
        $data = [
            'name' => 'test adjustment',
            'setting_uuid' => $setting->getAttribute('uuidText'),
            'schema' => $array
        ];

        // 3. Assertion
        $response = $this
            ->actingAs($actor, 'api')
            ->json('post',
                route('api.private.games.settings.store'),
                $data,
            );

        $response->assertStatus(200);
    }
}
