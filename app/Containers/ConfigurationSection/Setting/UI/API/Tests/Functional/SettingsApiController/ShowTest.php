<?php

namespace App\Containers\ConfigurationSection\Setting\UI\API\Tests\Functional\SettingsApiController;


use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\Setting\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test receive specific setting \
 * Covered scenarios: \
 *      1.Successfully receive setting by id
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Setting\UI\WEB\Controllers\SettingsWebController::show
 */
class ShowTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveSettingById(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $setting = Setting::factory()
            ->for($game)
            ->createOne();

        $gameApiToken = $game->createToken('game-api-token')->plainTextToken;

        // 2. Scenario running
        $response = $this
            ->json(
                method: 'get',
                uri: route('api.public.games.settings.show',
                    [
                        'game' => $game->getAttribute('id'),
                        'setting' => $setting->getAttribute('id')
                    ]
                ),
                headers: [
                    'X-GameToken' => $gameApiToken,
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
