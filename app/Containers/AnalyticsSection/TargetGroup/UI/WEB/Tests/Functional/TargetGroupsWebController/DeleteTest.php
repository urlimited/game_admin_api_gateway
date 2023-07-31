<?php

namespace App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Tests\Functional\TargetGroupsWebController;

use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Containers\AnalyticsSection\TargetGroup\Models\TargetGroup;
use App\Containers\AnalyticsSection\TargetGroup\Tests\ApiTestCase;
use App\Containers\AnalyticsSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription test deletes a new game target group \
 *  Covered scenarios: \
 *      1.Successfully delete target group \
 * @group target group
 * @group api
 * @covers \App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Controllers\TargetGroupsWebController::delete
 */
class DeleteTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyDeleteTargetGroup(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $actor = $this->asCommonCustomer(User::factory())
            ->hasAttached($game)
            ->createOne();

        $targetGroup = TargetGroup::factory()->for($game)->createOne();

        $this->assertDatabaseHas(
            'target_groups',
            [
                'name' => $targetGroup->getAttributes('name'),
                'game_id' => $game->getAttribute('id')
            ]
        );

        // 2. Scenario run
        $response = $this
            ->actingAs($actor, 'api')
            ->json(
                'delete',
                route(
                    'api.private.target-groups.delete',
                    [
                        'targetGroup' => $targetGroup->getUuidTextAttribute(),
                    ]
                )
            );

        // 3. Assertion
        $response->assertStatus(204);

        $this->assertDatabaseMissing(
            'target_groups',
            [
                'name' => $targetGroup->getAttribute('name'),
                'game_id' => $game->getAttribute('id'),
                'deleted_at' => null
            ]
        );
    }
}
