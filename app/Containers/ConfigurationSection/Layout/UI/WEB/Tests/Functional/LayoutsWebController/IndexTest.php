<?php

namespace App\Containers\ConfigurationSection\Layout\UI\WEB\Tests\Functional\LayoutsWebController;


use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Containers\ConfigurationSection\Layout\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test receive layout list
 *    Covered scenarios:
 *      1. Successfully receive the list of all layouts
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Layout\UI\WEB\Controllers\LayoutsWebController::index
 */
class IndexTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveTheListOfAllLayouts(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $user = $this->asCommonCustomer(User::factory()
            ->hasAttached($game)
        )->createOne();

        Layout::factory()
            ->count(10)
            ->for($game)
            ->create();

        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json(
                'get',
                route(
                    name: 'api.private.games.layouts.index',
                    parameters: [
                        'game_id' => $game->getAttribute('id')
                    ]
                )
            );

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'uuid',
                        'name',
                        'version',
                        'schema',
                    ]
                ]
            ]
        );
    }
}
