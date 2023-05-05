<?php

namespace App\Containers\GameManagementSection\Player\UI\API\Tests\Functional\PlayersApiController;

use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;
use Illuminate\Support\Facades\Hash;

/**
 * @desription Covers following scenarios: \
 *  1. Show a player within a correct game token and correct player token
 *  2. Fails to show player within incorrect player token
 *  3. Fails to show player that doesn't belong to current game
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Player\UI\API\Controllers\PlayersApiController::store
 */
class ShowTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyShowPlayer(): void
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
        $response = $this
            ->json(
                method: 'get',
                uri: route('api.public.players.show'),
                headers: [
                    'X-GameToken' => 'Bearer ' . $gameApiToken,
                    'X-PlayerToken' => 'Bearer ' . $playerApiToken,
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

    public function testFailsToShowPlayerWithIncorrectPlayerToken(): void
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
        $response = $this
            ->json(
                method: 'get',
                uri: route('api.public.players.show'),
                headers: [
                    'X-GameToken' => 'Bearer ' . $gameApiToken,
                    'X-PlayerToken' => 'Bearer ' . 'incorrect-player-token',
                ]
            );

        // 3. Assertion
        $response->assertStatus(401);
    }

    public function testFailsToShowPlayerWithOtherGameToken(): void
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
        $response = $this
            ->json(
                method: 'get',
                uri: route('api.public.players.show'),
                headers: [
                    'X-GameToken' => 'Bearer ' . $gameApiToken,
                    'X-PlayerToken' => 'Bearer ' . $playerApiToken,
                ]
            );

        // 3. Assertion
        $response->assertStatus(403);
    }
}
