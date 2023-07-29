<?php

namespace App\Containers\AnalyticsSection\StatEvent\UI\WEB\Tests\Functional\StatEventsWebController;


use App\Containers\AnalyticsSection\StatEvent\Models\StatEvent;
use App\Containers\AnalyticsSection\StatEvent\Tests\ApiTestCase;
use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Containers\AnalyticsSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test receive stat events list \
 *    Covered scenarios: \
 *      1.  Successfully receive the list of all stat events
 * @group user
 * @group api
 * @covers \App\Containers\AnalyticsSection\StatEvent\UI\WEB\Controllers\StatEventsWebController::index
 */
class IndexTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveTheListOfAllStatEvents(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $user = $this->asCommonCustomer(User::factory()
            ->hasAttached($game)
        )->createOne();

        StatEvent::factory()
            ->for($game)
            ->count(4)
            ->create();

        // 2.Scenarios run
        $data = [
            'game_uuid' => $game->getUuidTextAttribute()
        ];

        $response = $this
            ->actingAs($user, 'api')
            ->json('get',
                route('api.private.stat-events.index'),
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
                        'type',
                    ]
                ]
            ]
        );
    }
}
