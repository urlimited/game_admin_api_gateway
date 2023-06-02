<?php

namespace App\Containers\ConfigurationSection\Layout\UI\WEB\Tests\Functional\LayoutsWebController;

use App\Containers\ConfigurationSection\Layout\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription test creates a new game layout \
 *  Covered scenarios:
 *      1. Store successfully user
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Layout\UI\WEB\Controllers\LayoutsWebController::store
 */
class StoreTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyStoreLayout(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $user = $this->asCommonCustomer(User::factory()
            ->hasAttached($game)
        )->createOne();

        $json = '[{"name": "A","data_type": "list","rules": null,"children": [{"name": "A-C","data_type": "string","rules": null,"children": [{"name": "A-C-G","data_type": "string", "rules": null}]}, {"name": "A-E","data_type": "string","rules": null}]},{"name": "B", "data_type": "string", "rules": null, "children": [{"name": "B-D","data_type": "string","rules": null}]}]';

        $array = json_decode($json, true);

        // 2. Scenario run
        $data = [
            'name' => 'rerum',
            'game_uuid' => $game->getUuidTextAttribute(),
            'schema' => $array,
            'version' => '13.25.42',
        ];

        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('post',
                route('api.private.games.layouts.store'),
                $data,
            );

        $response->assertStatus(200);

        $this->assertDatabaseHas('layouts',
            [
                'name'=> 'rerum',
                'version'=> '13.25.42',
                'game_id'=> $game->getAttribute('id')
            ]
        );

    }
}
