<?php

namespace App\Containers\ConfigurationSection\Configuration\UI\API\Tests\Functional\ConfigurationsPrivateController;


use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\Structure\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * * @desription Successfully update configuration
 * Covered scenarious
 *       1. Successfully update configuration
 *        2. Successfully update configuration with null structure id
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Configuration\UI\API\Controllers\ConfigurationsPrivateController::update
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

        $userGameId = $user->games->pluck('id')->first();

        $configuration =Configuration::factory()
            ->for($structure)
            ->createOne();

        // 2. Scenario run
        $data = [
            'name'=>'rerum',
            'structure_id'=>$configuration->structure_id,
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
            'author_id'=>$user->id,
        ];


        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('put',
                route('api.private.games.configurations.update',
                    [
                        'game' => $userGameId,
                        'configuration'=>$configuration->id,
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

    public function testSuccessfullyUpdateConfigurationWithNullStructureId(): void
    {
        // 1. Initialization
        $game = Game::factory()->createOne();
        $user = User::factory()
            ->hasAttached($game)
            ->createOne();

        $userGameId = $user->games->pluck('id')->first();

        $configuration =Configuration::factory()
            ->createOne();

        // 2. Scenario run
        $data = [
            'name'=>'rerum',
            'structure_id'=>null,
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
            'author_id'=>$user->id,
        ];


        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('put',
                route('api.private.games.configurations.update',
                    [
                        'game' => $userGameId,
                        'configuration'=>$configuration->id,
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
