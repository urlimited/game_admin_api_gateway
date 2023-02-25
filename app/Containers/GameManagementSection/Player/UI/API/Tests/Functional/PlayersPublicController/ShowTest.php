<?php

namespace App\Containers\GameManagementSection\Player\UI\API\Tests\Functional\PlayersPublicController;

use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;
use Illuminate\Support\Facades\Hash;

/**
 * @desription Test provides assertion for correct players creating processes
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Player\UI\API\Controllers\PlayersPublicController::store
 */
class ShowTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyShowPlayer(): void
    {
        // 1. Initialization
        $game = Game::factory()->createOne();

        $player = Player::factory()
            ->createOne(
                [
                    'login' => 'login-test',
                    'game_id' => $game->getAttribute('id'),
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
}
