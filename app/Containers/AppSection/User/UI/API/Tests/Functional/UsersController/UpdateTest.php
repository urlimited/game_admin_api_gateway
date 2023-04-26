<?php

namespace App\Containers\AppSection\User\UI\API\Tests\Functional\UsersController;

use App\Containers\AppSection\Permission\Models\Permission;
use App\Containers\AppSection\Role\Models\Role;
use App\Containers\AppSection\User\Enums\UserStatus;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\UserUpdateTask;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use App\Ship\Parents\Tests\PhpUnit\GDRefreshDatabase;

/**
 * @desription Test provides assertion for correct players updating processes
 * Covered scenarios:
 *      1. Successfully update user
 *      2.Fail update other user
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

        // 2. Scenario run
        $newPermission = Permission::query()->orderByDesc('id')->value('id');
        $newRole = Role::query()->orderByDesc('id')->value('id');

        $data = [
            'login' => 'admin-test',
            'password' => 'secret',
            'status' => UserStatus::Active,
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
                'permission_id' => $newPermission->id,
            ]
        );
    }

    public function testFailUpdateOtherUser(): void
    {
        $this->seed();

        $roleId = Role::query()->where('name', 'admin')->value('id');

        $user = User::factory()->hasRoles([])->createOne();

        $user->roles()->attach($roleId);

        $userUpdated = app(UserUpdateTask::class)
            ->run(id: $user->id,
                status: 'active',
                roles: [1],
                permissions: [1],
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
