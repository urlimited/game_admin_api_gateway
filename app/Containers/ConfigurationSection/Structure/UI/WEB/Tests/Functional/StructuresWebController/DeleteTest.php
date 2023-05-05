<?php

namespace App\Containers\ConfigurationSection\Structure\UI\WEB\Tests\Functional\StructuresWebController;


use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\Structure\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Successfully delete structure
 * Covered scenarious
 *       1.specific game structure removed with Authenticated user
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Structure\UI\WEB\Controllers\StructuresWebController::delete
 */
class DeleteTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyDeleteStructure(): void
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


        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json(
                'delete',
                route(
                    name: 'api.private.games.structures.delete',
                    parameters: [
                        'structure' => $structure->id,
                    ]
                )
            );

        $response->assertStatus(204);
    }
}
