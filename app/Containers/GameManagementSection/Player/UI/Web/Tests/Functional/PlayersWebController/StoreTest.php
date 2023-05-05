<?php

namespace App\Containers\GameManagementSection\Player\UI\Web\Tests\Functional\PlayersWebController;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Covers following scenarios: \
 *  1. Create a player within a game that belong to the current user
 *  2. Fails to create a player within a game that doesn't belong to the current user
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Player\UI\Web\Controllers\PlayersWebController::store
 */
class StoreTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyCreatePlayer(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asCommonCustomer(User::factory())->createOne();

        $game = Game::factory()->hasAttached($actor)->createOne();

        // 2. Scenario run
        $data = [
            'login' => 'player-test-login',
            'password' => 'password',
            'game_id' => $game->getAttribute('id')
        ];

        $response = $this
            ->actingAs($actor)
            ->json(
                method: 'post',
                uri: route('api.private.games.players.store'),
                data: $data,
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

    public function testFailsToCreatePlayerForOtherGame(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asCommonCustomer(User::factory())->createOne();
        $otherUser = $this->asCommonCustomer(User::factory())->createOne();

        $game = Game::factory()->hasAttached($otherUser)->createOne();

        // 2. Scenario run
        $data = [
            'login' => 'player-test-login',
            'password' => 'password',
            'game_id' => $game->getAttribute('id')
        ];

        $response = $this
            ->actingAs($actor)
            ->json(
                method: 'post',
                uri: route('api.private.games.players.store'),
                data: $data,
            );

        // 3. Assertion
        $response->assertStatus(403);
    }
}
