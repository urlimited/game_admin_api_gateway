<?php

namespace App\Containers\ConfigurationSection\Structure\UI\Web\Tests\Functional\StructuresWebController;


use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\Structure\Tests\ApiTestCase;

use App\Ship\Parents\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test receive specific structure
 * Covered scenarios:
 *      1.Successfully receive structure by id
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Structure\UI\Web\Controllers\StructuresWebController::show
 */
class ShowTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveStructureById(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $user = User::factory()
            ->hasAttached($game)
            ->createOne();

        $structure = Structure::factory()
            ->for($game)
            ->createOne();

        // 2. Scenario run
        $response = $this
            ->actingAs($user, 'api')
            ->json('get',
                route(
                    name:'api.private.games.structures.show',
                    parameters: [
                        'structure'=> $structure->getAttribute('id')
                    ]
                )
            );

        // 3. Assertion
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                    'version',
                    'schema',
                ]
            ]
        );
    }
}
