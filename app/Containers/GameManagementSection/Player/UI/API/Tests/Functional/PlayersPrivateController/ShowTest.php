<?php

namespace App\Containers\GameManagementSection\Player\UI\API\Tests\Functional\PlayersPrivateController;

use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Containers\GameManagementSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;
use Illuminate\Support\Facades\Hash;

/**
 * @desription Test provides assertion for correct players creating processes
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Player\UI\API\Controllers\PlayersPrivateController::store
 */
class ShowTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyShowPlayer(): void
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
        $response = $this
            ->actingAs($user)
            ->json(
                method: 'get',
                uri: route(
                    'api.private.games.players.show',
                    [
                        'game' => $game->getAttribute('id'),
                        'player' => $player->getAttribute('id'),
                    ]
                ),
            );

        // 3. Assertion

        // 3.1 Assert response status
        $response->assertStatus(200);

        // 3.2 Assert response structure
        $response->assertJsonStructure(
            [
                'data' => [
                    'login',
                    'game_id',
                ]
            ]
        );
    }
}
