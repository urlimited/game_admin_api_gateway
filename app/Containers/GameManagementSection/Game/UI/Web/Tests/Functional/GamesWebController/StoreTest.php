<?php

namespace App\Containers\GameManagementSection\Game\UI\Web\Tests\Functional\GamesWebController;

use App\Containers\GameManagementSection\Game\Enums\GameGenre;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Covers following scenarios: \
 *  1. Standard game create flow with a Privileged Customer
 *  2. Fails to create a game from a Common Customer user
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Game\UI\Web\Controllers\GamesWebController::store
 */
class StoreTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyCreateGame(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asPrivilegedCustomer(User::factory())->createOne();

        // 2. Scenario run
        $data = [
            'name' => 'game-test',
            'genre' => GameGenre::RPG->value,
        ];

        $response = $this
            ->actingAs($actor)
            ->json(
                method: 'post',
                uri: route('api.games.create'),
                data: $data
            );

        // 3. Assertion
        $response->assertStatus(200);

        // We receive api_token first time from the create request
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                    'genre',
                    'api_token'
                ]
            ]
        );

        $parsedGameData = json_decode($response->getContent(), true)['data'];

        $this->assertEquals(
            $data['name'],
            $parsedGameData['name']
        );

        $this->assertEquals(
            $data['genre'],
            $parsedGameData['genre']
        );

        $this->assertDatabaseHas(
            'games',
            [
                'name' => $data['name'],
                'genre' => $data['genre']
            ]
        );

        $this->assertDatabaseHas(
            'game_user',
            [
                'game_id' => $parsedGameData['id'],
                'user_id' => $actor->id
            ]
        );
    }

    public function testFailsToCreateGameFromCommonCustomer(): void
    {
        // 1. Initialization
        $user = $this->asCommonCustomer(User::factory())->createOne();

        // 2. Scenario run
        $data = [
            'name' => 'game-test',
            'genre' => GameGenre::RPG->value,
        ];

        $response = $this
            ->actingAs($user)
            ->json(
                method: 'post',
                uri: route('api.games.create'),
                data: $data
            );

        // 3. Assertion
        $response->assertStatus(403);
    }
}
