<?php

namespace App\Containers\GameManagementSection\Game\UI\WEB\Tests\Functional\GamesWebController;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Covers following scenarios: \
 *  1. Standard game recreate api token flow with own game and authenticated user
 *  2. A user can't update others games tokens
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Game\UI\WEB\Controllers\GamesWebController::reCreateApiToken
 */
class ReCreateApiTokenTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyRefreshApiToken(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asPrivilegedCustomer(User::factory())->createOne();

        $game = Game::factory()
            ->hasAttached($actor)
            ->createOne();

        $oldToken = $game->createToken('old-token')->plainTextToken;

        // 2. Scenario run
        $data = [
            'api_token_name' => 'game-test-api-token-name'
        ];

        $response = $this
            ->actingAs($actor)
            ->json(
                method: 'post',
                uri: route(
                    'api.games.reCreateApiToken',
                    [
                        'game' => $game->getAttribute('uuidText'),
                    ]
                ),
                data: $data
            );

        // 3. Assertion
        $response->assertStatus(200);

        // We receive api_token first time from the create request
        $response->assertJsonStructure(
            [
                'data' => [
                    'uuid',
                    'name',
                    'genre',
                    'api_token'
                ]
            ]
        );

        $this->assertNotEquals($oldToken, json_decode($response->getContent(), true)['data']['api_token']);
    }

    public function testFailsToRefreshOtherGamesApiToken(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asPrivilegedCustomer(User::factory())->createOne();
        $otherUser = $this->asPrivilegedCustomer(User::factory())->createOne();

        $game = Game::factory()
            ->hasAttached($otherUser)
            ->createOne();

        // 2. Scenario run
        $data = [
            'api_token_name' => 'game-test-api-token-name'
        ];

        $response = $this
            ->actingAs($actor)
            ->json(
                method: 'post',
                uri: route(
                    'api.games.reCreateApiToken',
                    [
                        'game' => $game->getAttribute('uuidText'),
                    ]
                ),
                data: $data
            );

        // 3. Assertion
        $response->assertStatus(403);
    }
}
