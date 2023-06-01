<?php

namespace App\Containers\ConfigurationSection\Setting\UI\WEB\Tests\Functional\SettingsWebController;

use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Containers\ConfigurationSection\Setting\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Models\Permission;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;
use Illuminate\Support\Facades\File;

/**
 * @desription test creates a new game setting \
 *  Covered scenarios: \
 *      1.Successfully store setting \
 *      2.Successfully store setting with null layout id
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Setting\UI\WEB\Controllers\SettingsWebController::store
 */
class StoreTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyStoreSetting(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $actor = $this->asCommonCustomer(User::factory())
            ->hasAttached($game)
            ->createOne();

        $layout = Layout::factory()
            ->for($game)
            ->createOne();

        $json = File::get(__DIR__ . '/../../Stubs/CorrectSetting.json');

        $array = json_decode($json, true);

        // 2. Scenario run
        $data = [
            'name' => 'setting-test-name',
            'layout_uuid' => $layout->getAttribute('uuidText'),
            'game_uuid' => $game->getAttribute('uuidText'),
            'schema' => $array
        ];

        // 3. Assertion
        $response = $this
            ->actingAs($actor, 'api')
            ->json('post',
                route('api.private.games.settings.store'),
                $data,
            );

        $response->assertStatus(200);
    }


    public function testSuccessfullyStoreSettingWithNullLayoutId(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $user = $this->asCommonCustomer(User::factory()
            ->hasAttached($game)
        )->createOne();

        $json = File::get(__DIR__ . '/../../Stubs/CorrectSetting.json');

        $array = json_decode($json, true);

        // 2. Scenario run
        $data = [
            'name' => 'setting-test-name',
            'layout_uuid' => null,
            'game_uuid' => $game->getAttribute('uuidText'),
            'schema' => $array
        ];

        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('post',
                route('api.private.games.settings.store'),
                $data,
            );

        $response->assertStatus(200);
    }

    public function testFailsStoreSettingWithIncorrectData(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $layout = Layout::factory()
            ->for($game)
            ->createOne();

        $user = $this->asCommonCustomer(User::factory()
            ->hasAttached($game)
        )->createOne();

        $json = File::get(__DIR__ . '/../../Stubs/IncorrectSetting.json');

        $array = json_decode($json, true);

        // 2. Scenario run
        $data = [
            'name' => 'setting-test-name',
            'layout_uuid' => null,
            'game_uuid' => $game->getAttribute('uuidText'),
            'schema' => $array
        ];

        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('post',
                route('api.private.games.settings.store'),
                $data,
            );

        $response->assertStatus(422);
    }

    public function testFailsStoreSettingWithInvalidData(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $layout = Layout::factory()->for($game)
            ->createOne();

        $user = $this->asCommonCustomer(User::factory()
            ->hasAttached($game)
        )->createOne();

        $json = File::get(__DIR__ . '/../../Stubs/InvalidSetting.json');

        $array = json_decode($json, true);

        // 2. Scenario run
        $data = [
            'name' => 'setting-test-name',
            'layout_uuid' => $layout->getAttribute('uuidText'),
            'game_uuid' => $game->getAttribute('uuidText'),
            'schema' => $array
        ];

        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('post',
                route('api.private.games.settings.store'),
                $data,
            );

        $response->assertStatus(422);
    }
}
