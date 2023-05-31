<?php

namespace App\Containers\GameManagementSection\Game\UI\WEB\Tests\Functional\GamesWebController;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Containers\GameManagementSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;
use Ramsey\Uuid\Uuid;

/**
 * @desription Covers following scenarios: \
 *      1. Standard game show for the Authenticated user \
 *      2. Fails to show game that doesn't belong to the current user
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Game\UI\WEB\Controllers\GamesWebController::show
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
                uri: route(
                    'api.games.show',
                    [
                        'game' => $game->getAttribute('uuidText')
                    ]
                )
            );

        // 3. Assertion
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'uuid',
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
            $game->getAttribute('uuid'),
            Uuid::fromString($parsedGameData['uuid'])
                ->getBytes()
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
                uri: route(
                    'api.games.show',
                    [
                        'game' => $game->getAttribute('uuidText')
                    ]
                )
            );

        // 3. Assertion
        $response->assertStatus(403);
    }
}
