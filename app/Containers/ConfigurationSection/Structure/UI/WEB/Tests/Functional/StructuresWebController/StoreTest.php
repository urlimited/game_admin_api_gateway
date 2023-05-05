<?php

namespace App\Containers\ConfigurationSection\Structure\UI\WEB\Tests\Functional\StructuresWebController;

use App\Containers\ConfigurationSection\Structure\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription test creates a new game structure \
 *  Covered scenarios:
 *      1. Store successfully user
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Structure\UI\WEB\Controllers\StructuresWebController::store
 */
class StoreTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyStoreStructure(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();
        $user = User::factory()
            ->hasAttached($game)
            ->createOne();

        $json = '[{"name": "A","data_type": "list","rules": null,"children": [{"name": "A-C","data_type": "string","rules": null,"children": [{"name": "A-C-G","data_type": "string", "rules": null}]}, {"name": "A-E","data_type": "string","rules": null}]},{"name": "B", "data_type": "string", "rules": null, "children": [{"name": "B-D","data_type": "string","rules": null}]}]';

        $array = json_decode($json, true);

        // 2. Scenario run
        $data = [
            'name' => 'rerum',
            'game_id' => $game->getAttribute('id'),
            'schema' => $array,
            'version' => '13.25.42',
        ];




        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('post',
                route('api.private.games.structures.store'),
                $data,
            );

        $response->assertStatus(200);

        $this->assertDatabaseHas('structures',
            [
                'name'=> 'rerum',
                'version'=> '13.25.42',
                'game_id'=> $game->getAttribute('id'),
            ]
        );

    }
}
