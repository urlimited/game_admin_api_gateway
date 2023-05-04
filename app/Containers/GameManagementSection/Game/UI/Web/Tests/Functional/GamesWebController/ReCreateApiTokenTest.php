<?php

namespace App\Containers\GameManagementSection\Game\UI\Web\Tests\Functional\GamesWebController;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Containers\GameManagementSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Covers following scenarios: \
 *  1. Standard game recreate api token flow with Authenticated user
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Game\UI\Web\Controllers\GamesWebController::reCreateApiToken
 */
class ReCreateApiTokenTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyRefreshApiToken(): void
    {
        // 1. Initialization
        $user = User::factory()->createOne();

        $game = Game::factory()->createOne();

        $oldToken = $game->createToken('old-token')->plainTextToken;

        // 2. Scenario run
        $data = [
            'api_token_name' => 'game-test-api-token-name'
        ];

        $response = $this
            ->actingAs($user)
            ->json(
                method: 'post',
                uri: route('api.games.reCreateApiToken', $game->id),
                data: $data
            );

        // 3. Assertion
        $response->assertStatus(200);

        // We receive api_token first time from the create request
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                    'genre',
                    'api_token'
                ]
            ]
        );

        $this->assertNotEquals($oldToken, json_decode($response->getContent(), true)['data']['api_token']);
    }
}
