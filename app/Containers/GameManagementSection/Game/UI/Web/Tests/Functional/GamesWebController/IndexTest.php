<?php

namespace App\Containers\GameManagementSection\Game\UI\Web\Tests\Functional\GamesWebController;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\User\Models\User;
use App\Containers\GameManagementSection\Game\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Covers following scenarios: \
 *  1. Show all games for the Authenticated user
 * @group game
 * @group api
 * @covers \App\Containers\GameManagementSection\Game\UI\Web\Controllers\GamesWebController::index
 */
class IndexTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testShowAllGamesForCurrentUser(): void
    {
        // 1. Initialization
        $user = User::factory()
            ->hasAttached(
                Game::factory()->count(5)
            )
            ->createOne();

        // 2. Scenario run
        $response = $this
            ->actingAs($user)
            ->json(
                method: 'get',
                uri: route('api.games.index')
            );

        // 3. Assertion
        $response->assertStatus(200);
    }
}
