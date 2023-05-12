<?php

namespace App\Containers\AppSection\Permission\Data\Seeders;

use App\Containers\AppSection\Permission\Tasks\AttachPermissionsToRoleTask;
use Illuminate\Database\Seeder;

class PermissionsToRolesSeeder_3 extends Seeder
{
    public function run()
    {
        app(AttachPermissionsToRoleTask::class)
            ->run(
                'admin',
                [
                    'game-full-own-read',
                    'game-full-other-read',
                    'game-public-own-read',
                    'game-public-other-read',

                    'game-full-own-update',
                    'game-full-other-update',
                    'game-public-own-update',
                    'game-public-other-update',

                    'game-full-own-create',
                    'game-full-other-create',

                    'game-full-own-delete',
                    'game-full-other-delete',

                    'player-full-own-read',
                    'player-full-other-read',
                    'player-public-own-read',
                    'player-public-other-read',

                    'player-full-own-update',
                    'player-full-other-update',
                    'player-public-own-update',
                    'player-public-other-update',

                    'player-full-own-create',
                    'player-full-other-create',

                    'player-full-own-delete',
                    'player-full-other-delete',

                    'user-full-own-read',
                    'user-full-other-read',
                    'user-public-own-read',
                    'user-public-other-read',

                    'user-full-own-update',
                    'user-full-other-update',
                    'user-public-own-update',
                    'user-public-other-update',

                    'user-full-other-create',

                    'user-full-own-delete',
                    'user-full-other-delete',

                    'setting-full-own-read',
                    'setting-full-other-read',
                    'setting-public-own-read',
                    'setting-public-other-read',

                    'setting-full-own-update',
                    'setting-full-other-update',
                    'setting-public-own-update',
                    'setting-public-other-update',

                    'setting-full-own-create',
                    'setting-full-other-create',

                    'setting-full-own-delete',
                    'setting-full-other-delete',

                    'adjustment-full-own-read',
                    'adjustment-full-other-read',
                    'adjustment-public-own-read',
                    'adjustment-public-other-read',

                    'adjustment-full-own-update',
                    'adjustment-full-other-update',
                    'adjustment-public-own-update',
                    'adjustment-public-other-update',

                    'adjustment-full-own-create',
                    'adjustment-full-other-create',

                    'adjustment-full-own-delete',
                    'adjustment-full-other-delete',

                    'ab-test-full-own-read',
                    'ab-test-full-other-read',
                    'ab-test-public-own-read',
                    'ab-test-public-other-read',

                    'ab-test-full-own-update',
                    'ab-test-full-other-update',
                    'ab-test-public-own-update',
                    'ab-test-public-other-update',

                    'ab-test-full-own-create',
                    'ab-test-full-other-create',

                    'ab-test-full-own-delete',
                    'ab-test-full-other-delete',

                    'layout-full-own-read',
                    'layout-full-other-read',
                    'layout-public-own-read',
                    'layout-public-other-read',

                    'layout-full-own-update',
                    'layout-full-other-update',
                    'layout-public-own-update',
                    'layout-public-other-update',

                    'layout-full-own-create',
                    'layout-full-other-create',

                    'layout-full-own-delete',
                    'layout-full-other-delete',
                ]
            );

        app(AttachPermissionsToRoleTask::class)
            ->run(
                'common_customer',
                [
                    'game-full-own-read',
                    'game-public-own-read',
                    'game-public-other-read',

                    'game-public-own-update',
                    'game-public-other-update',

                    'player-full-own-read',
                    'player-public-own-read',

                    'player-full-own-update',
                    'player-public-own-update',

                    'player-full-own-create',

                    'player-full-own-delete',

                    'user-full-own-read',
                    'user-public-own-read',
                    'user-public-other-read',

                    'user-full-own-update',
                    'user-public-own-update',
                    'user-public-other-update',

                    'user-full-own-create',

                    'user-full-own-delete',

                    'setting-full-own-read',
                    'setting-public-own-read',

                    'setting-full-own-update',
                    'setting-public-own-update',

                    'setting-full-own-create',

                    'setting-full-own-delete',

                    'adjustment-full-own-read',
                    'adjustment-public-own-read',

                    'adjustment-full-own-update',
                    'adjustment-public-own-update',

                    'adjustment-full-own-create',

                    'adjustment-full-own-delete',

                    'ab-test-full-own-read',
                    'ab-test-public-own-read',

                    'ab-test-full-own-update',
                    'ab-test-public-own-update',

                    'ab-test-full-own-create',

                    'ab-test-full-own-delete',

                    'layout-full-own-read',
                    'layout-public-own-read',

                    'layout-full-own-update',
                    'layout-public-own-update',

                    'layout-full-own-create',

                    'layout-full-own-delete',
                ]
            );

        app(AttachPermissionsToRoleTask::class)
            ->run(
                'privileged_customer',
                [
                    'game-full-own-read',
                    'game-public-own-read',
                    'game-public-other-read',

                    'game-full-own-update',
                    'game-public-own-update',
                    'game-public-other-update',

                    'game-full-own-create',

                    'game-full-own-delete',

                    'player-full-own-read',
                    'player-public-own-read',
                    'player-public-other-read',

                    'player-full-own-update',
                    'player-public-own-update',
                    'player-public-other-update',

                    'player-full-own-create',

                    'player-full-own-delete',

                    'user-full-own-read',
                    'user-public-own-read',
                    'user-public-other-read',

                    'user-full-own-update',
                    'user-public-own-update',
                    'user-public-other-update',

                    'user-full-other-create',

                    'user-full-own-delete',

                    'setting-full-own-read',
                    'setting-public-own-read',

                    'setting-full-own-update',
                    'setting-public-own-update',

                    'setting-full-own-create',

                    'setting-full-own-delete',

                    'adjustment-full-own-read',
                    'adjustment-public-own-read',

                    'adjustment-full-own-update',
                    'adjustment-public-own-update',

                    'adjustment-full-own-create',

                    'adjustment-full-own-delete',

                    'ab-test-full-own-read',
                    'ab-test-public-own-read',

                    'ab-test-full-own-update',
                    'ab-test-public-own-update',

                    'ab-test-full-own-create',

                    'ab-test-full-own-delete',

                    'layout-full-own-read',
                    'layout-public-own-read',

                    'layout-full-own-update',
                    'layout-public-own-update',

                    'layout-full-own-create',

                    'layout-full-own-delete',
                ]
            );

        app(AttachPermissionsToRoleTask::class)
            ->run(
                'guest',
                [
                    'game-public-other-read',

                    'game-public-other-update',

                    'user-public-own-read',
                    'user-public-other-read',

                    'user-public-other-update',

                    'user-full-own-create',
                ]
            );
    }
}
