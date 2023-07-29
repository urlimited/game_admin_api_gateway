<?php

namespace App\Containers\GameManagementSection\Player\UI\WEB\Tests\Functional\PlayersWebController;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Covers following scenarios: \
 *  1. Index players within a game that belong to the current user
 *  2. Fails to index players within a game that doesn't belong to the current user
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Player\UI\WEB\Controllers\PlayersWebController::store
 */
class IndexTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyIndexedPlayers(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asCommonCustomer(User::factory())->createOne();

        $game = Game::factory()
            ->has(
                Player::factory()
                    ->count(5),
                'players'
            )
            ->hasAttached($actor)
            ->createOne();

        // 2. Scenario run
        $response = $this
            ->actingAs($actor)
            ->json(
                method: 'get',
                uri: route(
                    'api.private.games.players.index',
                    [
                        'game_uuid' => $game->getAttribute('uuidText')
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
                    '*' => [
                        'uuid',
                        'login',
                        'game_uuid',
                        'player_token'
                    ]
                ]
            ]
        );
    }

    public function testFailsToFetchPlayersFromOtherGame(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asCommonCustomer(User::factory())->createOne();
        $otherUser = $this->asCommonCustomer(User::factory())->createOne();

        $game = Game::factory()
            ->has(
                Player::factory()
                    ->count(5),
                'players'
            )
            ->hasAttached($otherUser)
            ->createOne();

        // 2. Scenario run
        $response = $this
            ->actingAs($actor)
            ->json(
                method: 'get',
                uri: route(
                    'api.private.games.players.index',
                    [
                        'game_id' => $game->getAttribute('id')
                    ]
                ),
            );

        // 3. Assertion
        $response->assertStatus(403);
    }
}
