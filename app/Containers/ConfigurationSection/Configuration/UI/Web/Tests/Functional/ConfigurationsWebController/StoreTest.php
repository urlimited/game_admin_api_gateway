<?php

namespace App\Containers\ConfigurationSection\Configuration\UI\Web\Tests\Functional\ConfigurationsWebController;

use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\Structure\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription test creates a new game configuration \
 *  Covered scenarios: \
 *      1.Successfully store configuration \
 *      2.Successfully store configuration with null structure id
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Configuration\UI\Web\Controllers\ConfigurationsWebController::store
 */
class StoreTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyStoreConfiguration(): void
    {
        // 1. Initialization
        $game = Game::factory()->createOne();
        $user = User::factory()
            ->hasAttached($game)
            ->createOne();

        $structure = Structure::factory()
            ->for($game)
            ->createOne();

        // 2. Scenario run
        $data = [
            'name' => 'rerum',
            'structure_id' => $structure->getAttribute('id'),
            'game_id' => $game->getAttribute('id'),
            'schema' => '[
                    {
                        "id": 1,
                        "name": "gold",
                        "icon": "/path/to/icon"
                    },
                    {
                        "id": 2,
                        "name": "crystal",
                        "icon": "/path/to/icon"
                    }
                ]',
        ];

        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('post',
                route('api.private.games.configurations.store'),
                $data,
            );

        $response->assertStatus(200);
    }


    public function testSuccessfullyStoreConfigurationWithNullStructureId(): void
    {
        // 1. Initialization
        $game = Game::factory()->createOne();
        $user = User::factory()
            ->hasAttached($game)
            ->createOne();

        // 2. Scenario run
        $data = [
            'name' => 'rerum',
            'structure_id' => null,
            'game_id' => $game->getAttribute('id'),
            'schema' => '[
                    {
                        "id": 1,
                        "name": "gold",
                        "icon": "/path/to/icon"
                    },
                    {
                        "id": 2,
                        "name": "crystal",
                        "icon": "/path/to/icon"
                    }
                ]',
        ];

        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('post',
                route('api.private.games.configurations.store'),
                $data,
            );

        $response->assertStatus(200);
    }

}
