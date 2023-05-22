<?php

namespace App\Containers\AppSection\User\UI\WEB\Tests\Functional\UsersWebController;

use App\Containers\AppSection\User\Tests\ApiTestCase;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test receive specific user
 * @group user
 * @group api
 * @covers \App\Containers\AppSection\User\UI\WEB\Controllers\UsersWebController::show
 */
class ShowTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyReceiveUserByUuidFromAdmin(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asAdmin(User::factory())->createOne();

        $userB = User::factory()->createOne();

        // 2. Scenario run
        $response = $this
            ->actingAs($actor, 'api')
            ->json('get',
                route('api.private.users.show',
                    [
                        'user' => $userB->getAttribute('uuidText'),
                    ]
                )
            );

        // 3. Assertion
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'uuid',
                    'login',
                ]
            ]
        );
    }


    public function testSuccessfullyReceiveUserByHimself(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asCommonCustomer(User::factory())->createOne();

        // 2. Scenario run
        $response = $this
            ->actingAs($actor, 'api')
            ->json('get',
                route('api.private.users.show',
                    [
                        'user' => $actor->getAttribute('uuidText'),
                    ]
                )
            );

        // 3. Assertion
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'uuid',
                    'login',
                ]
            ]
        );
    }


    public function testFailsToShowOtherUsersDataForCommonUser(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asCommonCustomer(User::factory())->createOne();

        $userB = User::factory()->createOne();

        // 2. Scenario run
        $response = $this
            ->actingAs($actor, 'api')
            ->json('get',
                route('api.private.users.show',
                    [
                        'user' => $userB->getAttribute('uuidText'),
                    ]
                )
            );

        // 3. Assertion
        $response->assertStatus(403);
    }
}
