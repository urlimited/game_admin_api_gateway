<?php

namespace App\Containers\AppSection\User\UI\API\Tests\Functional\UsersController;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\UserUpdateTask;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test provides assertion for correct players updating processes
 * @group user
 * @group api
 * @covers \App\Containers\AppSection\User\UI\API\Controllers\UsersController::update
 */
class UpdateTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyUpdateUser(): void
    {
        // 1. Initialization
        $this->seed();

        $user = User::factory()->createOne();

        // 2. Scenario run
        $data = [
            'login' => 'admin-test',
            'password' => 'secret',
        ];

        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('put',
                route('api.private.users.update',
                    [
                        'user' => $user->id,
                    ]
                ),
                $data,
            );

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'login',
                ]
            ]
        );
    }

    public function testFailUpdateOtherUser(): void
    {
        $user = User::factory()->createOne();

        $userUpdated = app(UserUpdateTask::class)
            ->run(
                login: 'user.test.login',
                password: '$nums1234'
            );

        $data = [

        ];

        $response = $this
            ->actingAs($userUpdated, 'api')
            ->json('put',
                route('api.private.users.update',
                    [
                        'user' => $user->id,
                    ]
                ),
                $data,
            );

        $response->assertStatus(403);
    }
}
