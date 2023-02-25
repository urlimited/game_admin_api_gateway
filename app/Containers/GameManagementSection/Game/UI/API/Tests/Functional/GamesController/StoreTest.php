<?php

namespace App\Containers\GameManagementSection\Game\UI\API\Tests\Functional\GamesController;

use App\Containers\GameManagementSection\User\Models\User;
use App\Containers\GameManagementSection\Game\Enums\GameGenre;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Covers following scenarios: \
 *  1. Standard game create flow with Authenticated user
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Game\UI\API\Controllers\GamesController::store
 */
class StoreTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyCreateGame(): void
    {
        // 1. Initialization
        $user = User::factory()->createOne();

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
                'user_id' => $user->id
            ]
        );
    }
}
