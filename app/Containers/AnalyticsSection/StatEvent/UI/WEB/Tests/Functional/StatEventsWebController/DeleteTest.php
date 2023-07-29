<?php

namespace App\Containers\AnalyticsSection\StatEvent\UI\WEB\Tests\Functional\StatEventsWebController;


use App\Containers\AnalyticsSection\StatEvent\Tests\ApiTestCase;
use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Containers\AnalyticsSection\StatEvent\Models\StatEvent;
use App\Containers\AnalyticsSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Successfully delete stat event \
 * Covered scenarios: \
 *       1. Successfully delete stat event
 * @group user
 * @group api
 * @covers \App\Containers\AnalyticsSection\StatEvent\UI\WEB\Controllers\StatEventsWebController::delete
 */
class DeleteTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyDeleteSetting(): void
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

        $this->assertDatabaseHas(
            'stat_events',
            [
                'game_id' => $game->getAttribute('id'),
                'id' => $statEvent->getAttribute('id'),
            ]
        );

        // 2. Scenarios run
        $response = $this
            ->actingAs($user, 'api')
            ->json('delete',
                route('api.private.stat-events.delete',
                    [
                        'statEvent' => $statEvent->getAttribute('uuidText')
                    ]
                )
            );

        // 3. Assertion
        $response->assertStatus(204);

        $this->assertDatabaseMissing(
            'stat_events',
            [
                'game_id' => $game->getAttribute('id'),
                'id' => $statEvent->getAttribute('id'),
                'deleted_at' => null
            ]
        );
    }
}
