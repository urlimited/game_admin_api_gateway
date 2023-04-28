<?php

namespace App\Containers\ConfigurationSection\Configuration\UI\API\Tests\Functional\ConfigurationsPrivateController;


use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Configuration\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test receive  configurations list
 *    Covered scenarios:
 *      1.  Successfully receive the list of all configurations
 *      2.  Successfully receive the list of all configurations with null structure id
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Configuration\UI\API\Controllers\ConfigurationsPrivateController::index
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

        $userGameId = $user->games->pluck('id')->first();

        Configuration::factory()
            ->for($structure)
            ->count(5)
            ->create();

        $data=[
            'structure_id'=>$structure->id
        ];
        //2.Scenarios run

        $response = $this
            ->actingAs($user, 'api')
            ->json('get',
                route('api.private.games.configurations.index',
                    [
                        'game' => $userGameId,
                    ]
                ),$data
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

    public function testSuccessfullyReceiveTheListOfAllConfigurationsWithNullStructureId(): void
    {
        // 1. Initialization
        $this->seed();
        $game = Game::factory()->createOne();
        $user = User::factory()
            ->hasAttached($game)
            ->createOne();

        $userGameId = $user->games->pluck('id')->first();

        Configuration::factory()
            ->count(5)
            ->create();


        //2.Scenarios run

        $response = $this
            ->actingAs($user, 'api')
            ->json('get',
                route('api.private.games.configurations.index',
                    [
                        'game' => $userGameId,
                    ]
                )
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
