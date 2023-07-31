<?php

namespace App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Tests\Functional\TargetGroupsWebController;

use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Containers\AnalyticsSection\TargetGroup\Models\TargetGroup;
use App\Containers\AnalyticsSection\TargetGroup\Tests\ApiTestCase;
use App\Containers\AnalyticsSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;
use Illuminate\Support\Facades\File;

/**
 * @desription test updates a new game target group \
 *  Covered scenarios: \
 *      1.Successfully update target group \
 * @group target group
 * @group api
 * @covers \App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Controllers\TargetGroupsWebController::update
 */
class UpdateTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyUpdateTargetGroup(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $actor = $this->asCommonCustomer(User::factory())
            ->hasAttached($game)
            ->createOne();

        $conditions = File::get(__DIR__ . '/../../Stubs/CorrectConditions.json');

        $targetGroup = TargetGroup::factory()->for($game)->createOne();

        $this->assertDatabaseHas(
            'target_groups',
            [
                'name' => $targetGroup->getAttributes('name'),
                'game_id' => $game->getAttribute('id')
            ]
        );

        // 2. Scenario run
        $data = [
            'name' => 'target updated test name',
            'conditions' => $conditions,
        ];

        $response = $this
            ->actingAs($actor, 'api')
            ->json(
                'put',
                route(
                    'api.private.target-groups.update',
                    [
                        'targetGroup' => $targetGroup->getUuidTextAttribute(),
                    ]
                ),
                $data
            );

        // 3. Assertion
        $response->assertStatus(204);

        $this->assertDatabaseHas(
            'target_groups',
            [
                'name' => $data['name'],
                'game_id' => $game->getAttribute('id')
            ]
        );
    }
}
