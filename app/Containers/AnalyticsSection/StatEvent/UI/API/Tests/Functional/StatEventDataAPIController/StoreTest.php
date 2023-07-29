<?php

namespace App\Containers\AnalyticsSection\StatEvent\UI\API\Tests\Functional\StatEventDataAPIController;

use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Containers\AnalyticsSection\StatEvent\Models\StatEvent;
use App\Containers\AnalyticsSection\StatEvent\Tests\ApiTestCase;
use App\Containers\AnalyticsSection\Player\Models\Player;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;
use Illuminate\Support\Facades\Hash;

/**
 * @desription test creates a new game stat event data \
 *  Covered scenarios: \
 *      1.Successfully store stat event data \
 * @group user
 * @group api
 * @covers \App\Containers\AnalyticsSection\StatEvent\UI\API\Controllers\StatEventDataAPIController::store
 */
class StoreTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyStoreStatEventData(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $player = Player::factory()
            ->for($game)
            ->createOne(
                [
                    'login' => 'login-test',
                    'password' => Hash::make('password-test'),
                ]
            );

        $gameApiToken = $game->createToken('game-api-token')->plainTextToken;
        $playerApiToken = $player->createToken('player-api-token')->plainTextToken;

        $statEvent = StatEvent::factory()->for($game)->createOne();

        // 2. Scenario run
        $data = [
            'stat_event_data' => [
                [
                    'value' => 'string value',
                    'stat_event_uuid' => $statEvent->getUuidTextAttribute(),
                ],
                [
                    'value' => '123',
                    'stat_event_uuid' => $statEvent->getUuidTextAttribute(),
                ]
            ]
        ];

        // 3. Assertion
        $response = $this
            ->json(
                method: 'post',
                uri: route('api.public.stat-event-data.store'),
                data: $data,
                headers: [
                    'X-GameToken' => $gameApiToken,
                    'X-PlayerToken' => $playerApiToken,
                ]
            );

        $response->assertStatus(201);

        $this->assertDatabaseHas(
            'stat_event_data',
            [
                'value' => 'string value',
                'stat_event_id' => $statEvent->getAttribute('id'),
            ]
        );

        $this->assertDatabaseHas(
            'stat_event_data',
            [
                'value' => '123',
                'stat_event_id' => $statEvent->getAttribute('id'),
            ]
        );
    }
}
