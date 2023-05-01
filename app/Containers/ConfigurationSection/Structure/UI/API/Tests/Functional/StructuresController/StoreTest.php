<?php

namespace App\Containers\ConfigurationSection\Structure\UI\API\Tests\Functional\StructuresController;

use App\Containers\ConfigurationSection\Structure\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription test creates a new game structure \
 *  Covered scenarios:
 *      1. Store successfully user
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Structure\UI\API\Controllers\StructuresController::store
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

        $userGameIds = $user->games->pluck('id')->first();

        // 2. Scenario run
        $data = [
                'name'=>'rerum',
                'game_id'=>$userGameIds,
                'schema'=>[
                    [
                        'path' => 'field1',
                        'data_type' => 'string',
                    ]
                ],
                'version'=>'13.25.42',
        ];


        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('post',
                route('api.private.games.structures.store',
                [
                    'game' => $userGameIds,
                ]
            ),
                $data,
            );

        $response->assertStatus(200);

        $this->assertDatabaseHas('structures',
            [
                'name'=> 'rerum',
                'version'=> '13.25.42',
                'game_id'=> $userGameIds,
            ]
        );

    }
}
