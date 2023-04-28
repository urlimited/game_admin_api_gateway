<?php

namespace App\Containers\ConfigurationSection\Configuration\UI\API\Tests\Functional\ConfigurationsPublicController;


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
 * @covers \App\Containers\ConfigurationSection\Configuration\UI\API\Controllers\ConfigurationsPrivateController::show
 */
class ShowTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveConfigurationById(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $configuration = Configuration::factory()
            ->for($game)
            ->createOne();

        $gameApiToken = $game->createToken('game-api-token')->plainTextToken;

        // 2. Scenario running
        $response = $this
            ->json(
                method: 'get',
                uri: route('api.public.games.configurations.show',
                    [
                        'game' => $game->getAttribute('id'),
                        'configuration' => $configuration->getAttribute('id')
                    ]
                ),
                headers: [
                    'X-GameToken' => 'Bearer ' . $gameApiToken,
                ]
            );

        // 3. Assertion
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                    'schema',
                ]
            ]
        );
    }
}
