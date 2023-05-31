<?php

namespace App\Containers\GameManagementSection\Player\UI\API\Tests\Functional\PlayersApiController;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;
use Illuminate\Support\Facades\Hash;

/**
 * @desription Covers following scenarios: \
 *  1. Update a player within a correct game token and correct player token
 *  2. Fails to update player within incorrect player token
 *  3. Fails to update player that doesn't belong to current game
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Player\UI\API\Controllers\PlayersApiController::update
 */
class UpdateTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyUpdatePlayer(): void
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

        // 2. Scenario run
        $data = [
            'password' => 'password-updated-test'
        ];

        $response = $this
            ->json('put',
                route('api.public.players.update'),
                $data,
                [
                    'X-GameToken' => $gameApiToken,
                    'X-PlayerToken' => $playerApiToken,
                ]
            );

        // 3. Assertion
        $response->assertStatus(200);

        // We receive api_token first time from the create request
        $response->assertJsonStructure(
            [
                'data' => [
                    'uuid',
                    'login',
                    'game_id',
                ]
            ]
        );
    }

    public function testFailsToUpdatePlayerWithIncorrectToken(): void
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

        // 2. Scenario run
        $data = [
            'password' => 'password-updated-test'
        ];

        $response = $this
            ->json('put',
                route('api.public.players.update'),
                $data,
                [
                    'X-GameToken' => $gameApiToken,
                    'X-PlayerToken' => 'incorrect-player-token',
                ]
            );

        // 3. Assertion
        $response->assertStatus(401);
    }

    public function testFailsToUpdatePlayerWithOtherGameToken(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();
        $anotherGame = Game::factory()->createOne();

        $player = Player::factory()
            ->for($anotherGame)
            ->createOne(
                [
                    'login' => 'login-test',
                    'password' => Hash::make('password-test'),
                ]
            );

        $gameApiToken = $game->createToken('game-api-token')->plainTextToken;
        $playerApiToken = $player->createToken('player-api-token')->plainTextToken;

        // 2. Scenario run
        $data = [
            'password' => 'password-updated-test'
        ];

        $response = $this
            ->json('put',
                route('api.public.players.update'),
                $data,
                [
                    'X-GameToken' => $gameApiToken,
                    'X-PlayerToken' => $playerApiToken,
                ]
            );

        // 3. Assertion
        $response->assertStatus(403);
    }
}
