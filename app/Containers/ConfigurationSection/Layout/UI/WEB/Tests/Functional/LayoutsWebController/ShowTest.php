<?php

namespace App\Containers\ConfigurationSection\Layout\UI\WEB\Tests\Functional\LayoutsWebController;


use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Containers\ConfigurationSection\Layout\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test receive specific layout
 * Covered scenarios:
 *      1.Successfully receive layout by id
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Layout\UI\WEB\Controllers\LayoutsWebController::show
 */
class ShowTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveLayoutById(): void
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

        // 2. Scenario run
        $response = $this
            ->actingAs($user, 'api')
            ->json('get',
                route(
                    name:'api.private.games.layouts.show',
                    parameters: [
                        'layout'=> $layout->getUuidTextAttribute()
                    ]
                )
            );

        // 3. Assertion
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                    'version',
                    'schema',
                ]
            ]
        );
    }
}
