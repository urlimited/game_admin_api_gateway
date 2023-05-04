<?php

namespace App\Containers\ConfigurationSection\Configuration\UI\Web\Tests\Functional\ConfigurationsWebController;


use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Configuration\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test receive specific configuration \
 * Covered scenarios: \
 *      1.Successfully receive configuration by id
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Configuration\UI\Web\Controllers\ConfigurationsWebController::show
 */
class ShowTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveConfigurationById(): void
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

        $configuration = Configuration::factory()
            ->for($structure)
            ->for($game)
            ->createOne();


        // 2. Scenario running
        $response = $this
            ->actingAs($user, 'api')
            ->json('get',
                route('api.private.games.configurations.show',
                    [
                        'game' => $game->getAttribute('id'),
                        'configuration' => $configuration->getAttribute('id')
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
                    'structure_id',
                    'schema',
                    'author_id',
                ]
            ]
        );
    }
}
