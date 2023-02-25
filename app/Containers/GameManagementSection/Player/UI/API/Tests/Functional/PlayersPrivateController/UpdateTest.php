<?php

namespace App\Containers\GameManagementSection\Player\UI\API\Tests\Functional\PlayersPrivateController;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Containers\GameManagementSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;
use Illuminate\Support\Facades\Hash;

/**
 * @desription Test provides assertion for correct players updating processes
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Player\UI\API\Controllers\PlayersPublicController::update
 */
class UpdateTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyUpdatePlayer(): void
    {
        // 1. Initialization
        $user = User::factory()->createOne();

        $game = Game::factory()->createOne();

        $user->games()->attach($game->getAttribute('id'));

        $player = Player::factory()
            ->createOne(
                [
                    'login' => 'login-test',
                    'game_id' => $game->getAttribute('id'),
                    'password' => Hash::make('password-test'),
                ]
            );

        // 2. Scenario run
        $data = [
            'password' => 'password-updated-test'
        ];

        $response = $this
            ->actingAs($user)
            ->json(
                method: 'put',
                uri: route(
                    'api.private.games.players.update',
                    [
                        'game' => $game->getAttribute('id'),
                        'player' => $player->getAttribute('id'),
                    ]
                ),
                data: $data,
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
