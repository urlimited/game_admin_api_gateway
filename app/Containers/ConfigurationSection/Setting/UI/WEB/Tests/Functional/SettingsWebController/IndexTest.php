<?php

namespace App\Containers\ConfigurationSection\Setting\UI\WEB\Tests\Functional\SettingsWebController;


use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\Setting\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Models\Permission;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test receive  settings list \
 *    Covered scenarios: \
 *      1.  Successfully receive the list of all settings
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Setting\UI\WEB\Controllers\SettingsWebController::index
 */
class IndexTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveTheListOfAllSettings(): void
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

        Setting::factory()
            ->for($layout)
            ->for($game)
            ->count(5)
            ->create();

        $data=[
            'layout_uuid' => $layout->getAttribute('uuidText'),
            'game_uuid' => $game->getAttribute('uuidText'),
        ];

        // 2.Scenarios run
        $response = $this
            ->actingAs($user, 'api')
            ->json('get',
                route('api.private.games.settings.index'),
                $data
            );

        // 3. Assertion
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'uuid',
                        'name',
                        'layout_uuid',
                        'game_uuid',
                        'schema',
                    ]
                ]
            ]
        );
    }
}
