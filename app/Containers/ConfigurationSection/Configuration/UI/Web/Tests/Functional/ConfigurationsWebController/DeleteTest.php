<?php

namespace App\Containers\ConfigurationSection\Configuration\UI\Web\Tests\Functional\ConfigurationsWebController;


use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Configuration\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Successfully delete configuration \
 * Covered scenarios: \
 *       1. Successfully delete configuration
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Configuration\UI\Web\Controllers\ConfigurationsWebController::delete
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

        $configuration = Configuration::factory()
            ->for($structure)
            ->for($game)
            ->createOne();

        // 2. Scenarios run
        $response = $this
            ->actingAs($user, 'api')
            ->json('delete',
                route('api.private.games.configurations.delete',
                    [
                        'game' => $game->getAttribute('id'),
                        'configuration' => $configuration->getAttribute('id')
                    ]
                )
            );

        // 3. Assertion
        $response->assertStatus(204);
    }
}
