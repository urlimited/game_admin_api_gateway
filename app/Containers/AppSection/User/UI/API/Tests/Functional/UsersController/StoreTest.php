<?php

namespace App\Containers\AppSection\User\UI\API\Tests\Functional\UsersController;

use App\Containers\AppSection\User\Enums\UserStatus;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription test creates new users with permission, role and status//
 * @group user
 * @group api
 * @covers \App\Containers\AppSection\User\UI\API\Controllers\UsersController::store
 */
class StoreTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testStoreSuccessfullyUser(): void
    {
        // 1. Initialization
        $this->seed();

        $user = User::factory()->createOne();

        // 2. Scenario run
        $data = [
            'login' => 'admin-test',
            'password' => 'secret',
            'status' => UserStatus::Active,
            'permissions' => [1],
            'roles' => [1],
        ];

        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('post', route('api.private.users.store'), $data);

        $response->assertStatus(200);

        $this->assertEquals(
            $data['login'],
            json_decode($response->getContent(), true)['data']['login']
        );

        $this->assertDatabaseHas('users',
            [
                'login' => $data['login']
            ]
        );
    }
}
