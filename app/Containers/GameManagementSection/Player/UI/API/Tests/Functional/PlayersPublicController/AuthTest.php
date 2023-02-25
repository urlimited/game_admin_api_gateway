<?php

namespace App\Containers\GameManagementSection\Player\UI\API\Tests\Functional\PlayersPublicController;

use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;
use Illuminate\Support\Facades\Hash;

/**
 * @desription Test provides assertion for correct players authentication process
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Player\UI\API\Controllers\PlayersPublicController::store
 */
class AuthTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyAuthenticatePlayer(): void
    {
        // 1. Initialization
        $game = Game::factory()
            ->has(
                Player::factory()
                    ->state(
                        [
                            'login' => 'login-test',
                            'password' => Hash::make('password-test')
                        ]
                    ),
                'players'
            )
            ->createOne();

        $gameApiToken = $game->createToken('game-api-token')->plainTextToken;

        // 2. Scenario run
        $data = [
            'login' => 'login-test',
            'password' => 'password-test',
        ];

        $response = $this
            ->json(
                method: 'post',
                uri: route('api.public.players.auth'),
                data: $data,
                headers: [
                    'X-GameToken' => 'Bearer ' . $gameApiToken
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
                    'id',
                    'login',
                    'game_id',
                    'player_token'
                ]
            ]
        );

        // 3.3 Assert affects on the DB
        $this->assertDatabaseHas('personal_access_tokens',
            [
                'tokenable_type' => Player::class,
                'name' => 'player-api-token',
                'tokenable_id' => $parsedResponse['id'],
            ]
        );
    }
}
