<?php

namespace App\Containers\ConfigurationSection\Configuration\UI\WEB\Tests\Functional\ConfigurationsWebController;


use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\Structure\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Successfully update configuration \
 *      Covered scenarios: \
 *          1. Successfully update configuration
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Configuration\UI\WEB\Controllers\ConfigurationsWebController::update
 */
class UpdateTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyUpdateConfiguration(): void
    {
        // 1. Initialization
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

        // 2. Scenario run
        $data = [
            'name' => 'rerum',
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
            ->json('put',
                route('api.private.games.configurations.update',
                    [
                        'game' => $game->getAttribute('id'),
                        'configuration' => $configuration->getAttribute('id'),
                    ]
                ),
                $data,
            );

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                    'structure_id',
                    'schema',
                    'author_id'
                ]
            ]
        );

        $this->assertEquals(
            $data['name'],
            json_decode($response->getContent(), true)['data']['name']
        );
    }
}
