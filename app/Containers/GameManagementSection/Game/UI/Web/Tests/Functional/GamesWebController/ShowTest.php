<?php

namespace App\Containers\GameManagementSection\Game\UI\Web\Tests\Functional\GamesWebController;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Containers\GameManagementSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Covers following scenarios: \
 *      1. Standard game show for the Authenticated user \
 *      2. Fails to show game that doesn't belong to the current user
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Game\UI\Web\Controllers\GamesWebController::show
 */
class ShowTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testShowGameSuccessfully(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $actor = $this->asCommonCustomer(User::factory())
            ->hasAttached($game)
            ->createOne();

        // 2. Scenario run
        $response = $this
            ->actingAs($actor)
            ->json(
                method: 'get',
                uri: route('api.games.show', ['game_id' => $game->getAttribute('id')])
            );

        // 3. Assertion
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                    'genre'
                ]
            ]
        );

        $parsedGameData = json_decode($response->getContent(), true)['data'];

        $this->assertEquals(
            $game->getAttribute('name'),
            $parsedGameData['name']
        );

        $this->assertEquals(
            $game->getAttribute('id'),
            $parsedGameData['id']
        );
    }

    public function testFailsShowGameForOtherUser(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $actor = $this->asCommonCustomer(User::factory())->createOne();

        $this->asCommonCustomer(User::factory())
            ->hasAttached($game)
            ->createOne();

        // 2. Scenario run
        $response = $this
            ->actingAs($actor)
            ->json(
                method: 'get',
                uri: route('api.games.show', ['game_id' => $game->getAttribute('id')])
            );

        // 3. Assertion
        $response->assertStatus(403);
    }
}
