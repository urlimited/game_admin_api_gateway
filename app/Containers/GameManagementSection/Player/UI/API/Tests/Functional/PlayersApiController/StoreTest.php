<?php

namespace App\Containers\GameManagementSection\Player\UI\API\Tests\Functional\PlayersApiController;

use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Covers following scenarios: \
 *  1. Create a player within a correct game token
 *  2. Fails to create player within incorrect game token
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Player\UI\API\Controllers\PlayersApiController::store
 */
class StoreTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyCreatePlayer(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $gameApiToken = $game->createToken('game-api-token')->plainTextToken;

        // 2. Scenario run
        $data = [
            'login' => 'player-test-login',
            'password' => 'password',
        ];

        $response = $this
            ->json(
                method: 'post',
                uri: route('api.public.players.store'),
                data: $data,
                headers: [
                    'X-GameToken' => $gameApiToken
                ]
            );

        // 3. Assertion

        // 3.1 Assert response status
        $response->assertStatus(200);

        // 3.2 Assert response structure
        $parsedResponse = json_decode($response->getContent(), true)['data'];

        $response->assertJsonStructure(
            [
                'data' => [
                    'login',
                    'game_id',
                    'player_token'
                ]
            ]
        );

        // 3.3 Assert affects on the DB
        $this->assertDatabaseHas('players',
            [
                'login' => $parsedResponse['login'],
                'game_id' => $parsedResponse['game_id'],
            ]
        );

        $this->assertDatabaseHas('personal_access_tokens',
            [
                'tokenable_type' => Player::class,
                'name' => 'player-api-token',
                'tokenable_id' => $parsedResponse['id'],
            ]
        );
    }

    public function testFailsToCreatePlayerWithIncorrectGameToken(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $game->createToken('game-api-token')->plainTextToken;

        // 2. Scenario run
        $data = [
            'login' => 'player-test-login',
            'password' => 'password',
        ];

        $response = $this
            ->json(
                method: 'post',
                uri: route('api.public.players.store'),
                data: $data,
                headers: [
                    'X-GameToken' => 'incorrect-game-token'
                ]
            );

        // 3. Assertion
        $response->assertStatus(401);
    }
}
