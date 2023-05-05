<?php

namespace App\Containers\ConfigurationSection\Configuration\UI\WEB\Tests\Functional\ConfigurationsWebController;


use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Configuration\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test receive  configurations list \
 *    Covered scenarios: \
 *      1.  Successfully receive the list of all configurations
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Configuration\UI\WEB\Controllers\ConfigurationsWebController::index
 */
class IndexTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveTheListOfAllConfigurations(): void
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

        Configuration::factory()
            ->for($structure)
            ->for($game)
            ->count(5)
            ->create();

        $data=[
            'structure_id' => $structure->id,
            'game_id' => $game->getAttribute('id'),
        ];

        // 2.Scenarios run
        $response = $this
            ->actingAs($user, 'api')
            ->json('get',
                route('api.private.games.configurations.index'),
                $data
            );

        // 3. Assertion
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'structure_id',
                        'schema',
                        'author_id',
                    ]
                ]
            ]
        );
    }
}
