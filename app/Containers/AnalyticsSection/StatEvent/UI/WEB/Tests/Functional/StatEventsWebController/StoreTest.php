<?php

namespace App\Containers\AnalyticsSection\StatEvent\UI\WEB\Tests\Functional\StatEventsWebController;

use App\Containers\AnalyticsSection\StatEvent\Enums\StatEventType;
use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Containers\AnalyticsSection\StatEvent\Tests\ApiTestCase;
use App\Containers\AnalyticsSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription test creates a new game stat event \
 *  Covered scenarios: \
 *      1.Successfully store stat event \
 * @group user
 * @group api
 * @covers \App\Containers\AnalyticsSection\StatEvent\UI\WEB\Controllers\StatEventsWebController::store
 */
class StoreTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyStoreStatEvent(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $actor = $this->asCommonCustomer(User::factory())
            ->hasAttached($game)
            ->createOne();

        // 2. Scenario run
        $data = [
            'name' => 'stat event name',
            'type' => StatEventType::Quantitative->value,
            'game_uuid' => $game->getUuidTextAttribute(),
        ];

        // 3. Assertion
        $response = $this
            ->actingAs($actor, 'api')
            ->json(
                'post',
                route('api.private.stat-events.store'),
                $data
            );

        $response->assertStatus(200);

        $this->assertDatabaseHas(
            'stat_events',
            [
                'name' => $data['name'],
                'type' => $data['type'],
                'game_id' => $game->getAttribute('id')
            ]
        );
    }
}
