<?php

namespace App\Containers\ConfigurationSection\Setting\UI\WEB\Tests\Functional\SettingsWebController;

use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Containers\ConfigurationSection\Layout\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription test creates a new game setting \
 *  Covered scenarios: \
 *      1.Successfully store setting \
 *      2.Successfully store setting with null layout id
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Setting\UI\WEB\Controllers\SettingsWebController::store
 */
class StoreTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyStoreSetting(): void
    {
        // 1. Initialization
        $game = Game::factory()->createOne();
        $user = User::factory()
            ->hasAttached($game)
            ->createOne();

        $layout = Layout::factory()
            ->for($game)
            ->createOne();

        $json = '{
            "players": [
                {
                    "name": "Adam",
                    "rank": "global"
                },
                {
                    "name": "Bob",
                    "rank": "global"
                }
            ],
            "maps": [
                {
                    "name": "dust",
                    "width": 1500,
                    "height": 1400
                }
            ]
        }';

        $array = json_decode($json, true);

        // 2. Scenario run
        $data = [
            'name' => 'rerum',
            'structure_id' => $layout->getAttribute('id'),
            'game_id' => $game->getAttribute('id'),
            'schema' => $array
        ];

        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('post',
                route('api.private.games.settings.store'),
                $data,
            );

        $response->assertStatus(200);
    }


    public function testSuccessfullyStoreSettingWithNullLayoutId(): void
    {
        // 1. Initialization
        $game = Game::factory()->createOne();
        $user = User::factory()
            ->hasAttached($game)
            ->createOne();

        $json = '{
            "players": [
                {
                    "name": "Adam",
                    "rank": "global"
                },
                {
                    "name": "Bob",
                    "rank": "global"
                }
            ],
            "maps": [
                {
                    "name": "dust",
                    "width": 1500,
                    "height": 1400
                }
            ]
        }';

        $array = json_decode($json, true);

        // 2. Scenario run
        $data = [
            'name' => 'rerum',
            'structure_id' => null,
            'game_id' => $game->getAttribute('id'),
            'schema' => $array
        ];

        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('post',
                route('api.private.games.settings.store'),
                $data,
            );

        $response->assertStatus(200);
    }

}
