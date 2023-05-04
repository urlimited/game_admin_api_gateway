<?php

namespace App\Containers\GameManagementSection\Player\UI\API\Tests\Functional\PlayersApiController;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;
use Illuminate\Support\Facades\Hash;

/**
 * @desription Test provides assertion for correct players updating processes
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
        // $this->seed();
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
        $data = [
            'password' => 'password-updated-test'
        ];

        $response = $this
            ->json('put',
                route('api.public.players.update'),
                $data,
                [
                    'X-GameToken' => 'Bearer ' . $gameApiToken,
                    'X-PlayerToken' => 'Bearer ' . $playerApiToken,
                ]
            );

        // 3. Assertion
        $response->assertStatus(200);

        // We receive api_token first time from the create request
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'login',
                    'game_id',
                ]
            ]
        );
    }
}
