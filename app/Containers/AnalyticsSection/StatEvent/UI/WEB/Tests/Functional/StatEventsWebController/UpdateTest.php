<?php

namespace App\Containers\AnalyticsSection\StatEvent\UI\WEB\Tests\Functional\StatEventsWebController;


use App\Containers\AnalyticsSection\StatEvent\Models\StatEvent;
use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Containers\AnalyticsSection\StatEvent\Tests\ApiTestCase;
use App\Containers\AnalyticsSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Successfully update setting \
 *      Covered scenarios: \
 *          1. Successfully update stat event \
 * @group user
 * @group api
 * @covers \App\Containers\AnalyticsSection\StatEvent\UI\WEB\Controllers\StatEventsWebController::update
 */
class UpdateTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyUpdateStatEvent(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $user = $this->asCommonCustomer(User::factory()
            ->hasAttached($game)
        )->createOne();

        $statEvent = StatEvent::factory()->for($game)->createOne();

        // 2. Scenario run
        $data = [
            'name' => 'rename123',
        ];


        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('put',
                route('api.private.stat-events.update',
                    [
                        'statEvent' => $statEvent->getAttribute('uuidText'),
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
                    'type',
                ]
            ]
        );

        $this->assertDatabaseHas(
            'stat_events',
            [
                'name' => $data['name'],
                'id' => $statEvent->getAttribute('id'),
            ]
        );
    }
}
