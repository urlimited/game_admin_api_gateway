<?php

namespace App\Containers\ConfigurationSection\Adjustment\UI\WEB\Tests\Functional\AdjustmentsWebController;

use App\Containers\ConfigurationSection\Adjustment\Models\Adjustment;
use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\Adjustment\Tests\ApiTestCase;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Successfully delete adjustment \
 * Covered scenarios: \
 *       1. Successfully delete adjustment \
 *       2. Fails to delete adjustment that breaks other adjustment structure
 * @group user
 * @group api
 * @covers \App\Containers\ConfigurationSection\Adjustment\UI\WEB\Controllers\AdjustmentsWebController::delete
 */
class DeleteTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyDeleteAdjustment(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $user = $this->asCommonCustomer(User::factory()
            ->hasAttached($game)
        )->createOne();

        $setting = Setting::factory()
            ->for($game)
            ->createOne();

        $adjustment = Adjustment::factory()
            ->for($setting)
            ->for($user)
            ->createOne();

        // 2. Scenarios run
        $response = $this
            ->actingAs($user, 'api')
            ->json('delete',
                route('api.private.adjustments.delete',
                    [
                        'adjustment' => $adjustment->getAttribute('uuidText')
                    ]
                )
            );

        // 3. Assertion
        $response->assertStatus(204);
    }
}
