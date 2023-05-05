<?php

namespace App\Containers\AppSection\User\UI\Web\Tests\Functional\UsersWebController;

use App\Containers\AppSection\User\Enums\UserStatus;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use App\Ship\Parents\Models\Permission;
use App\Ship\Parents\Models\Role;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription test creates new users with permission, role and status//
 * Covered scenarios:
 *      1. Store successfully user
 *      2. Failed to store a new user from common customer

 * @group user
 * @group api
 * @covers \App\Containers\AppSection\User\UI\Web\Controllers\UsersWebController::store
 */
class StoreTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testStoreSuccessfullyUser(): void
    {
        // 1. Initialization
        $this->seed();

        $user = $this->asAdmin(User::factory())->createOne();

        $roles = Role::query()->where('name','common_customer')->value('id');

        $permission = Permission::query()->where('name','game-full-own-read')->value('id');

        // 2. Scenario run
        $data = [
            'login' => 'admin-test',
            'password' => 'secret',
            'status' => UserStatus::Active,
            'roles'=>[$roles],
            'permissions'=>[$permission],
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

    public function testFailsToStoreUserFromCustomer(): void
    {
        // 1. Initialization
        $this->seed();

        $user = $this->asCommonCustomer(User::factory())->createOne();
        $roles = Role::query()->where('name','common_customer')->value('id');
        $permission = Permission::query()->where('name','game-full-own-read')->value('id');
        // 2. Scenario run
        $data = [
            'login' => 'admin-test',
            'password' => 'secret',
            'status' => UserStatus::Active,
            'roles'=>[$roles],
            'permissions'=>[$permission],
        ];

        // 3. Assertion
        $response = $this
            ->actingAs($user, 'api')
            ->json('post', route('api.private.users.store'), $data);

        $response->assertStatus(403);
    }
}
