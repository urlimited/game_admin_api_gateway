<?php

namespace App\Containers\GameManagementSection\Game\UI\WEB\Tests\Functional\GamesWebController;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Covers following scenarios: \
 *  1. Standard game update by privileged user
 *  2. A user can't update others games
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Game\UI\WEB\Controllers\GamesWebController::update
 */
class UpdateTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyUpdateGame(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asPrivilegedCustomer(User::factory())->createOne();

        $game = Game::factory()->hasAttached($actor)->createOne();

        // 2. Scenario run
        $data = [
            'name' => 'new-test-name'
        ];

        $response = $this
            ->actingAs($actor)
            ->json(
                method: 'put',
                uri: route(
                    'api.games.update',
                    [
                        'game' => $game->id,
                    ]
                ),
                data: $data
            );

        // 3. Assertion
        $response->assertStatus(200);

        // We receive api_token first time from the create request
        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                ]
            ]
        );

        $this->assertEquals(
            $data['name'],
            json_decode($response->getContent(), true)['data']['name']
        );
    }

    public function testFailsUpdateOthersGame(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asPrivilegedCustomer(User::factory())->createOne();
        $otherUser = $this->asPrivilegedCustomer(User::factory())->createOne();

        $game = Game::factory()->hasAttached($otherUser)->createOne();

        // 2. Scenario run
        $data = [
            'name' => 'new-test-name'
        ];

        $response = $this
            ->actingAs($actor)
            ->json(
                method: 'put',
                uri: route(
                    'api.games.update',
                    [
                        'game' => $game->id,
                    ]
                ),
                data: $data
            );

        // 3. Assertion
        $response->assertStatus(403);
    }
}
