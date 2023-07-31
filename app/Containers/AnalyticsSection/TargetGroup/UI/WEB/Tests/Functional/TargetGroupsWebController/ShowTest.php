<?php

namespace App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Tests\Functional\TargetGroupsWebController;


use App\Containers\AnalyticsSection\StatEvent\Tests\ApiTestCase;
use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Containers\AnalyticsSection\TargetGroup\Models\TargetGroup;
use App\Containers\AnalyticsSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test receive specific target group \
 * Covered scenarios: \
 *      1.Successfully receive target group by uuid
 * @group user
 * @group api
 * @covers \App\Containers\AnalyticsSection\StatEvent\UI\WEB\Controllers\StatEventsWebController::show
 */
class ShowTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveTargetGroupById(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $user = $this->asCommonCustomer(User::factory()
            ->hasAttached($game)
        )->createOne();

        $targetGroup = TargetGroup::factory()
            ->for($game)
            ->createOne();


        // 2. Scenario running
        $response = $this
            ->actingAs($user, 'api')
            ->json('get',
                route('api.private.target-groups.show',
                    [
                        'targetGroup' => $targetGroup->getAttribute('uuidText')
                    ]
                )
            );

        // 3. Assertion
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'uuid',
                    'name',
                    'conditions',
                ]
            ]
        );
    }
}
