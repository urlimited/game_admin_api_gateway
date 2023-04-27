<?php

namespace App\Containers\GameManagementSection\Game\UI\API\Tests\Functional\GamesController;

use App\Containers\GameManagementSection\User\Models\User;
use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Covers following scenarios: \
 *  1. Standard game delete flow with Authenticated user
 *
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Game\UI\API\Controllers\GamesController::delete
 */
class DeleteTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyDeleteGame(): void
    {
        // 1. Initialization
        $user = User::factory()->createOne();

        $game = Game::factory()->createOne();

        $gameApiToken = $game->createToken('game-api-token')->plainTextToken;

        // 2. Scenario run
        $response = $this
            ->actingAs($user)
            ->json(
                method: 'delete',
                uri: route(
                    'api.games.delete',
                    [
                        'game' => $game->id,
                    ]
                ),
                headers: [
                    'X-GameToken' => 'Bearer ' . $gameApiToken
                ]
            );

        // 3. Assertion
        $response->assertStatus(204);
    }
}
