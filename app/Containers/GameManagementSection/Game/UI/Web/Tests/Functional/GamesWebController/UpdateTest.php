<?php

namespace App\Containers\GameManagementSection\Game\UI\Web\Tests\Functional\GamesWebController;

use App\Containers\GameManagementSection\User\Models\User;
use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Covers following scenarios: \
 *  1. Standard game update flow with Authenticated user
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Game\UI\Web\Controllers\GamesWebController::update
 */
class UpdateTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyUpdateGame(): void
    {
        // 1. Initialization
        $user = User::factory()->createOne();

        $game = Game::factory()->createOne();

        $gameApiToken = $game->createToken('game-api-token')->plainTextToken;

        // 2. Scenario run
        $data = [
            'name' => 'new-test-name'
        ];

        $response = $this
            ->actingAs($user)
            ->json(
                method: 'put',
                uri: route(
                    'api.games.update',
                    [
                        'game' => $game->id,
                    ]
                ),
                data: $data,
                headers: [
                    'X-GameToken' => 'Bearer ' . $gameApiToken
                ]
            );

        // 3. Assertion
        $response->assertStatus(200);

        // We receive api_token first time from the create request
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                ]
            ]
        );

        $this->assertEquals(
            $data['name'],
            json_decode($response->getContent(), true)['data']['name']
        );
    }
}
