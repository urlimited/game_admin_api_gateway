<?php

namespace App\Containers\GameManagementSection\Player\UI\Web\Tests\Functional\PlayersWebController;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test provides assertion for correct players authentication process
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Player\UI\Web\Controllers\PlayersWebController::store
 */
class IndexTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyIndexedPlayers(): void
    {
        // 1. Initialization
        $user = User::factory()->createOne();

        $game = Game::factory()
            ->has(
                Player::factory()
                    ->count(5),
                'players'
            )
            ->createOne();

        $user->games()->attach($game->getAttribute('id'));

        // 2. Scenario run
        $response = $this
            ->actingAs($user)
            ->json(
                method: 'get',
                uri: route('api.private.games.players.index', ['game' => $game->getAttribute('id')]),
            );

        // 3. Assertion

        // 3.1 Assert response status
        $response->assertStatus(200);

        // 3.2 Assert response structure
        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'login',
                        'game_id',
                    ]
                ]
            ]
        );
    }
}
