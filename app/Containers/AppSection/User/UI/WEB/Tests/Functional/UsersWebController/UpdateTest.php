<?php

namespace App\Containers\AppSection\User\UI\WEB\Tests\Functional\UsersWebController;

use App\Containers\AppSection\User\Enums\UserStatus;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use App\Ship\Parents\Models\Permission;
use App\Ship\Parents\Models\Role;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test provides assertion for correct players updating processes
 * Covered scenarios:
 *      1. Successfully update personal user data
 *      2. Fail to update roles, permissions, and status for common user by himself
 *      3. Successfully update another user data by admin
 *      4. Fail update other user
 * @group user
 * @group api
 * @covers \App\Containers\AppSection\User\UI\WEB\Controllers\UsersWebController::update
 */
class UpdateTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyUpdateSelfData(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asCommonCustomer(User::factory())->createOne();

        // 2. Scenario run
        $data = [
            'password' => 'sEcret1$',
        ];

        $response = $this
            ->actingAs($actor, 'api')
            ->json('patch',
                route('api.private.users.update',
                    [
                        'user' => $actor->getAttribute('uuidText'),
                    ]
                ),
                $data,
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

    public function testFailsToUpdateRolesPermissionsAndStatusForCommonUserForHimself(): void
    {
        // 1. Initialization
        $this->seed();

        $actor = $this->asCommonCustomer(User::factory())->createOne();

        // 2. Scenario run
        $newPermission = Permission::query()->orderByDesc('id')->value('id');
        $newRole = Role::query()->orderByDesc('id')->value('id');

        $data = [
            'password' => 'sEcret1$',
            'status' => UserStatus::OnCheck,
            'permissions' => [
                $newPermission
            ],
            'roles' => [
                $newRole
            ]
        ];

        $response = $this
            ->actingAs($actor, 'api')
            ->json('patch',
                route('api.private.users.update',
                    [
                        'user' => $actor->getAttribute('uuidText'),
                    ]
                ),
                $data,
            );

        // 3. Assertion
        $response->assertStatus(403);
    }

    public function testSuccessfullyUpdateAnotherUserDataByAdmin(): void
    {
        // 1. Initialization
        $this->seed();

        $admin = $this->asAdmin(User::factory())->createOne();

        $otherUser = $this->asCommonCustomer(User::factory())->createOne();

        // 2. Scenario run
        $newPermission = Permission::query()->orderByDesc('id')->value('id');
        $newRole = Role::query()->orderByDesc('id')->value('id');

        $data = [
            'password' => 'sEcret1$',
            'status' => UserStatus::OnCheck,
            'permissions' => [
                $newPermission
            ],
            'roles' => [
                $newRole
            ]
        ];

        $response = $this
            ->actingAs($admin, 'api')
            ->json('patch',
                route('api.private.users.update',
                    [
                        'user' => $otherUser->getAttribute('uuidText'),
                    ]
                ),
                $data,
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

        $this->assertDatabaseHas(
            'user_has_permissions',
            [
                'user_id' => $otherUser->id,
                'permission_id' => $newPermission,
            ]
        );

        $this->assertDatabaseHas(
            'user_has_roles',
            [
                'role_id' => $newRole,
                'user_id' => $otherUser->id,
            ]
        );
    }

    public function testFailUpdateOtherUser(): void
    {
        $this->seed();

        $user = $this->asCommonCustomer(User::factory())->createOne();

        // 2. Scenario run
        $otherUser = User::factory()->createOne();

        $data = [
            'password' => 'sEcret1$',
        ];

        $response = $this
            ->actingAs($user, 'api')
            ->json('patch',
                route('api.private.users.update',
                    [
                        'user' => $otherUser->getAttribute('uuidText'),
                    ]
                ),
                $data,
            );

        $response->assertStatus(403);
    }
}
