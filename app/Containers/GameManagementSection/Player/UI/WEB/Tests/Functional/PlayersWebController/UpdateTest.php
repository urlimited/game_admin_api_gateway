<?php

namespace App\Containers\GameManagementSection\Player\UI\WEB\Tests\Functional\PlayersWebController;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Containers\GameManagementSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;
use Illuminate\Support\Facades\Hash;

/**
 * @desription Covers following scenarios: \
 *  1. Update a player within a game that belong to the current user
 *  2. Fails to update a player within a game that doesn't belong to the current user
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

        $actor = $this->asCommonCustomer(User::factory())->createOne();

        $game = Game::factory()
            ->has(
                Player::factory()
                    ->state(
                        [
                            'login' => 'login-test',
                            'password' => Hash::make('password-test'),
                        ]
                    )
            )
            ->hasAttached($actor)
            ->createOne();

        // 2. Scenario run
        $data = [
            'password' => 'password-updated-test',
            'game_id' => $game->getAttribute('id'),
        ];

        $response = $this
            ->actingAs($actor)
            ->json(
                method: 'put',
                uri: route(
                    'api.private.games.players.update',
                    [
                        'player' => $game->players()->first()->getAttribute('uuidText'),
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
                    'uuid',
                    'login',
                    'game_id',
                ]
            ]
        );
    }

    public function testFailsToUpdatePlayerFromOtherGames(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asCommonCustomer(User::factory())->createOne();
        $user = $this->asCommonCustomer(User::factory())->createOne();

        $game = Game::factory()
            ->has(
                Player::factory()
                    ->state(
                        [
                            'login' => 'login-test',
                            'password' => Hash::make('password-test'),
                        ]
                    )
            )
            ->hasAttached($user)
            ->createOne();

        // 2. Scenario run
        $data = [
            'password' => 'password-updated-test',
            'game_id' => $game->getAttribute('id'),
        ];

        $response = $this
            ->actingAs($actor)
            ->json(
                method: 'put',
                uri: route(
                    'api.private.games.players.update',
                    [
                        'player' => $game->players()->first()->getAttribute('uuidText'),
                    ]
                ),
                data: $data,
            );

        // 3. Assertion
        $response->assertStatus(403);
    }
}
