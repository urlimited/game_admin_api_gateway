<?php

namespace App\Containers\ConfigurationSection\Structure\UI\API\Tests\Functional\StructuresController;


use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\Structure\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test receive structure list
 *    Covered scenarios:
 *      1. Successfully receive the list of all structures
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Structure\UI\API\Controllers\StructuresController::index
 */
class IndexTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveTheListOfAllStructures(): void
    {
        // 1. Initialization
        $this->seed();
        $game = Game::factory()->createOne();
        $user = User::factory()
            ->hasAttached($game)
            ->createOne();

        $userGameIds = $user->games->pluck('id')->first();

        Structure::factory()
            ->count(10)
            ->create(['game_id' => $userGameIds]);

        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('get',
                route('api.private.games.structures.index',
                [
                    'game'=>$userGameIds
                ]
                )
            );

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'version',
                        'fields',
                    ]
                ]
            ]
        );
    }
}
