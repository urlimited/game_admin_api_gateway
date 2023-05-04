<?php

namespace App\Containers\GameManagementSection\Game\UI\Web\Tests\Functional\GamesWebController;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\User\Models\User;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Covers following scenarios: \
 *  1. Standard game show for the Authenticated user
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Game\UI\Web\Controllers\GamesWebController::show
 */
class ShowTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testShowGame(): void
    {
        // 1. Initialization
        $games = Game::factory()->count(5)->create();

        $user = User::factory()
            ->hasAttached($games)
            ->createOne();

        // 2. Scenario run
        $response = $this
            ->actingAs($user)
            ->json(
                method: 'get',
                uri: route('api.games.show', ['game' => $games->first()->id])
            );

        // 3. Assertion
        $response->assertStatus(200);

        // We receive api_token first time from the create request
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
            $games->first()['name'],
            $parsedGameData['name']
        );

        $this->assertEquals(
            $games->first()['id'],
            $parsedGameData['id']
        );
    }
}
