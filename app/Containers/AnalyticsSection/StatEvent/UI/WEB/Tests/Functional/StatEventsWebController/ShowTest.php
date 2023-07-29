<?php

namespace App\Containers\AnalyticsSection\StatEvent\UI\WEB\Tests\Functional\StatEventsWebController;


use App\Containers\AnalyticsSection\StatEvent\Models\StatEvent;
use App\Containers\AnalyticsSection\StatEvent\Tests\ApiTestCase;
use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Containers\AnalyticsSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test receive specific stat event \
 * Covered scenarios: \
 *      1.Successfully receive stat event by uuid
 * @group user
 * @group api
 * @covers \App\Containers\AnalyticsSection\StatEvent\UI\WEB\Controllers\StatEventsWebController::show
 */
class ShowTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveStatEventById(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $user = $this->asCommonCustomer(User::factory()
            ->hasAttached($game)
        )->createOne();

        $statEvent = StatEvent::factory()
            ->for($game)
            ->createOne();


        // 2. Scenario running
        $response = $this
            ->actingAs($user, 'api')
            ->json('get',
                route('api.private.stat-events.show',
                    [
                        'statEvent' => $statEvent->getAttribute('uuidText')
                    ]
                )
            );

        // 3. Assertion
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'uuid',
                    'name',
                    'type',
                ]
            ]
        );
    }
}
