<?php

namespace App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Tests\Functional\TargetGroupsWebController;


use App\Containers\AnalyticsSection\TargetGroup\Tests\ApiTestCase;
use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Containers\AnalyticsSection\TargetGroup\Models\TargetGroup;
use App\Containers\AnalyticsSection\User\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test receive target groups list \
 *    Covered scenarios: \
 *      1.  Successfully receive the list of all target groups
 * @group user
 * @group api
 * @covers \App\Containers\AnalyticsSection\StatEvent\UI\WEB\Controllers\StatEventsWebController::index
 */
class IndexTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveTheListOfAllTargetGroups(): void
    {
        // 1. Initialization
        $this->seed();

        $game = Game::factory()->createOne();

        $user = $this->asCommonCustomer(User::factory()
            ->hasAttached($game)
        )->createOne();

        TargetGroup::factory()
            ->for($game)
            ->count(4)
            ->create();

        // 2.Scenarios run
        $data = [
            'game_uuid' => $game->getUuidTextAttribute()
        ];

        $response = $this
            ->actingAs($user, 'api')
            ->json('get',
                route('api.private.target-groups.index'),
                $data
            );

        // 3. Assertion
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'uuid',
                        'name',
                        'conditions',
                    ]
                ]
            ]
        );
    }
}
