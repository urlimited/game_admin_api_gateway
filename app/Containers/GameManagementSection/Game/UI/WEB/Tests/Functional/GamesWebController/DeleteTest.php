<?php

namespace App\Containers\GameManagementSection\Game\UI\WEB\Tests\Functional\GamesWebController;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Covers following scenarios: \
 *  1. Standard game delete flow with privileged user and his game
 *  2. Fails to delete a game with incorrect game token
 *  3. Fails to delete a game that doesn't belong to the user
 *
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Game\UI\WEB\Controllers\GamesWebController::delete
 */
class DeleteTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyDeleteGame(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asPrivilegedCustomer(User::factory())->createOne();

        $game = Game::factory()
            ->hasAttached($actor)
            ->createOne();

        $gameApiToken = $game->createToken('game-api-token')->plainTextToken;

        // 2. Scenario run
        $response = $this
            ->actingAs($actor)
            ->json(
                method: 'delete',
                uri: route(
                    'api.games.delete',
                    [
                        'game' => $game->getAttribute('uuidText'),
                    ]
                ),
                headers: [
                    'X-GameToken' =>  $gameApiToken,
                ]
            );
        // 3. Assertion
        $response->assertStatus(204);
    }

    public function testFailToDeleteGameWithIncorrectGameToken(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asPrivilegedCustomer(User::factory())->createOne();

        $game = Game::factory()
            ->hasAttached($actor)
            ->createOne();

        $game->createToken('game-api-token')->plainTextToken;

        // 2. Scenario run
        $response = $this
            ->actingAs($actor)
            ->json(
                method: 'delete',
                uri: route(
                    'api.games.delete',
                    [
                        'game' => $game->getAttribute('uuidText'),
                    ]
                ),
                headers: [
                    'X-GameToken' => 'incorrect game token',
                ]
            );

        // 3. Assertion
        $response->assertStatus(403);
    }

    public function testFailToDeleteOtherGame(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asPrivilegedCustomer(User::factory())->createOne();
        $otherUser = $this->asPrivilegedCustomer(User::factory())->createOne();

        $game = Game::factory()
            ->hasAttached($otherUser)
            ->createOne();

        $gameApiToken = $game->createToken('game-api-token')->plainTextToken;

        // 2. Scenario run
        $response = $this
            ->actingAs($actor)
            ->json(
                method: 'delete',
                uri: route(
                    'api.games.delete',
                    [
                        'game' => $game->getAttribute('uuidText'),
                    ]
                ),
                headers: [
                    'X-GameToken' => $gameApiToken,
                ]
            );

        // 3. Assertion
        $response->assertStatus(403);
    }
}
