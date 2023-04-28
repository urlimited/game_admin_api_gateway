<?php

namespace App\Containers\ConfigurationSection\Configuration\UI\API\Tests\Functional\ConfigurationsPrivateController;


use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Configuration\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Models\Structure;

use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Successfully delete configuration
 * Covered scenarious
 *       1. Successfully delete configuration
 *       2. Successfully delete configuration with null structure id
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Configuration\UI\API\Controllers\ConfigurationsPrivateController::delete
 */
class DeleteTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyDeleteConfiguration(): void
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

        $configuration =Configuration::factory()
            ->for($structure)
            ->createOne();


       //2.Scenarios run
        $response = $this
            ->actingAs($user, 'api')
            ->json('delete',
                route('api.private.games.configurations.delete',
                    [
                        'game' => $userGameId,
                        'configuration'=>$configuration->id
                    ]
                )
            );
        // 3. Assertion
        $response->assertStatus(204);

    }

    public function testSuccessfullyDeleteConfigurationWithNullStructureId(): void
    {
        // 1. Initialization
        $this->seed();
        $game = Game::factory()->createOne();
        $user = User::factory()
            ->hasAttached($game)
            ->createOne();

        $userGameId = $user->games->pluck('id')->first();

        $configuration =Configuration::factory()
            ->createOne();


        //2.Scenarios run
        $response = $this
            ->actingAs($user, 'api')
            ->json('delete',
                route('api.private.games.configurations.delete',
                    [
                        'game' => $userGameId,
                        'configuration'=>$configuration->id
                    ]
                )
            );
        // 3. Assertion
        $response->assertStatus(204);

    }

}
