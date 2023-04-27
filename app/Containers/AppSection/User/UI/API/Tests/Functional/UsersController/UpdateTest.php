<?php

namespace App\Containers\AppSection\User\UI\API\Tests\Functional\UsersController;

use App\Containers\AppSection\Permission\Models\Permission;
use App\Containers\AppSection\Role\Models\Role;
use App\Containers\AppSection\User\Enums\UserStatus;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test provides assertion for correct players updating processes
 * Covered scenarios:
 *      1. Successfully update user
 *      2. Successfully update another user data
 *      3.Successfully update user own data
 *      4.Fail update other user
 * @group user
 * @group api
 * @covers \App\Containers\AppSection\User\UI\API\Controllers\UsersController::update
 */
class UpdateTest extends ApiTestCase
{
    use GDRefreshDatabase;

    public function testSuccessfullyUpdateSelfData(): void
    {
        // 1. Initialization
        $this->seed();
        $roleId = Role::query()->where('name', 'admin')->value('id');

        $user = User::factory()->createOne();
        $user->roles()->attach($roleId);

        $status =UserStatus::Active;
        // 2. Scenario run
        $newPermission = Permission::query()->orderByDesc('id')->value('id');
        $newRole = Role::query()->orderByDesc('id')->value('id');

        $data = [
            'login' => 'admin-test',
            'password' => 'secret',
            'status' => $status,
            'permissions' => [
                $newPermission
            ],
            'roles' => [
                $newRole
            ]
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

     $this->assertDatabaseHas(
            'user_has_permissions',
            [
                'user_id' => $user->id,
                'permission_id' => $newPermission,
            ]
        );

        $this->assertDatabaseHas(
            'user_has_roles',
            [
                'role_id' => $newRole,
                'user_id' => $user->id,
            ]
        );

    }

    public function testSuccessfullyUpdateAnotherUserData(): void
    {
        // 1. Initialization
        $this->seed();
        $adminRoleId = Role::query()->where('name', 'admin')->value('id');
        $userRoleId = Role::query()->where('name', 'common_customer')->value('id');

        $admin = User::factory()->createOne();
        $admin->roles()->attach($adminRoleId);

        $user = User::factory()->createOne();
        $user->roles()->attach($userRoleId);

        // 2. Scenario run
        $newPermission = Permission::query()->orderByDesc('id')->value('id');
        $newRole = Role::query()->orderByDesc('id')->value('id');

        $data = [
            'login' => 'user-test',
            'password' => 'secret',
            'status' => UserStatus::OnCheck,
            'permissions' => [
                $newPermission
            ],
            'roles' => [
                $newRole
            ]
        ];

        // 3. Assertion
        $response = $this
            ->actingAs($admin, 'api')
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

        $this->assertDatabaseHas(
            'user_has_permissions',
            [
                'user_id' => $user->id,
                'permission_id' => $newPermission,
            ]
        );

        $this->assertDatabaseHas(
            'user_has_roles',
            [
                'role_id' => $newRole,
                'user_id' => $user->id,
            ]
        );
    }


    public function testSuccessfullyUpdateUserOwnData(): void
    {
        // 1. Initialization
        $this->seed();
        $roleId = Role::query()->where('name', 'common_customer')->value('id');

        $user = User::factory()->createOne();
        $user->roles()->attach($roleId);

        // 2. Scenario run
        $defaultPermission = Permission::query()->where('name','user-full-own-update')->value('id');


        $data = [
            'login' => 'user-test',
            'password' => 'secret',
            'status' => UserStatus::Active,
            'permissions' => [
                $defaultPermission
            ],
            'roles' => [
                $roleId
            ]
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

        $this->assertDatabaseHas(
            'user_has_permissions',
            [
                'user_id' => $user->id,
                'permission_id' => $defaultPermission,
            ]
        );

        $this->assertDatabaseHas(
            'user_has_roles',
            [
                'role_id' => $roleId,
                'user_id' => $user->id,
            ]
        );
    }


    public function testFailUpdateOtherUser(): void
    {
        $this->seed();

        $roleId = Role::query()->where('name', 'common_customer')->value('id');
        $user = User::factory()->createOne();

        $user->roles()->attach($roleId);

        // 2. Scenario run
        $defaultPermission = Permission::query()->where('name','user-full-own-update')->value('id');

        $otherUser = User::factory()->createOne();

        $data = [
            'login' => 'user-test',
            'password' => 'secret',
            'status' => UserStatus::OnCheck,
            'permissions' => [
                $defaultPermission
            ],
            'roles' => [
                $roleId
            ]
        ];

        $response = $this
            ->actingAs($user, 'api')
            ->json('put',
                route('api.private.users.update',
                    [
                        'user' => $otherUser->id,
                    ]
                ),
                $data,
            );

        $response->assertStatus(403);

    }
}
