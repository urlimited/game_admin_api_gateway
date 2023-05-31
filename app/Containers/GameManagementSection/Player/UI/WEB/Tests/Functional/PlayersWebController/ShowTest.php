<?php

namespace App\Containers\GameManagementSection\Player\UI\WEB\Tests\Functional\PlayersWebController;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;
use Illuminate\Support\Facades\Hash;

/**
 * @desription Covers following scenarios: \
 *  1. Show a player within a game that belong to the current user
 *  2. Fails to show a player within a game that doesn't belong to the current user
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Player\UI\WEB\Controllers\PlayersWebController::show
 */
class ShowTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyShowPlayer(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asCommonCustomer(User::factory())->createOne();

        $game = Game::factory()
            ->hasAttached($actor)
            ->has(
                Player::factory()
                    ->state(
                        [
                            'login' => 'login-test',
                            'password' => Hash::make('password-test'),
                        ]
                    )
            )
            ->createOne();

        // 2. Scenario run
        $response = $this
            ->actingAs($actor)
            ->json(
                method: 'get',
                uri: route(
                    'api.private.games.players.show',
                    [
                        'player' => $game->players()->first()->getAttribute('uuidText'),
                    ]
                ),
                data: [
                    'game_uuid' => $game->getAttribute('uuidText')
                ]
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

    public function testFailsToShowPlayerFromOtherGame(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asCommonCustomer(User::factory())->createOne();
        $user = $this->asCommonCustomer(User::factory())->createOne();

        $game = Game::factory()
            ->hasAttached($user)
            ->has(
                Player::factory()
                    ->state(
                        [
                            'login' => 'login-test',
                            'password' => Hash::make('password-test'),
                        ]
                    )
            )
            ->createOne();

        // 2. Scenario run
        $response = $this
            ->actingAs($actor)
            ->json(
                method: 'get',
                uri: route(
                    'api.private.games.players.show',
                    [
                        'player' => $game->players()->first()->getAttribute('uuidText'),
                    ]
                ),
            );

        // 3. Assertion
        $response->assertStatus(403);
    }
}
