<?php

namespace App\Containers\ConfigurationSection\Setting\UI\WEB\Tests\Functional\SettingsWebController;


use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\Setting\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Models\Permission;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Successfully delete setting \
 * Covered scenarios: \
 *       1. Successfully delete setting
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Setting\UI\WEB\Controllers\SettingsWebController::delete
 */
class DeleteTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyDeleteSetting(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $user = $this->asCommonCustomer(User::factory()
            ->hasAttached($game)
        )->createOne();

        $layout = Layout::factory()
            ->for($game)
            ->createOne();

        $setting = Setting::factory()
            ->for($layout)
            ->for($game)
            ->createOne();

        // 2. Scenarios run
        $response = $this
            ->actingAs($user, 'api')
            ->json('delete',
                route('api.private.games.settings.delete',
                    [
                        'game' => $game->getAttribute('id'),
                        'setting' => $setting->getAttribute('id')
                    ]
                )
            );

        // 3. Assertion
        $response->assertStatus(204);
    }
}
