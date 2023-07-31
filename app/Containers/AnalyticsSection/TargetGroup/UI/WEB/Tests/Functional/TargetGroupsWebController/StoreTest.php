<?php

namespace App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Tests\Functional\TargetGroupsWebController;

use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Containers\AnalyticsSection\TargetGroup\Tests\ApiTestCase;
use App\Containers\AnalyticsSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;
use Illuminate\Support\Facades\File;

/**
 * @desription test creates a new game target group \
 *  Covered scenarios: \
 *      1.Successfully store target group \
 * @group user
 * @group api
 * @covers \App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Controllers\TargetGroupsWebController::store
 */
class StoreTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyStoreTargetGroup(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $actor = $this->asCommonCustomer(User::factory())
            ->hasAttached($game)
            ->createOne();

        $conditions = File::get(__DIR__ . '/../../Stubs/CorrectConditions.json');

        // 2. Scenario run
        $data = [
            'name' => 'target group test name',
            'conditions' => $conditions,
            'game_uuid' => $game->getUuidTextAttribute(),
        ];

        $response = $this
            ->actingAs($actor, 'api')
            ->json(
                'post',
                route('api.private.target-groups.store'),
                $data
            );

        // 3. Assertion
        $response->assertStatus(201);

        $this->assertDatabaseHas(
            'target_groups',
            [
                'name' => $data['name'],
                'game_id' => $game->getAttribute('id')
            ]
        );
    }
}
