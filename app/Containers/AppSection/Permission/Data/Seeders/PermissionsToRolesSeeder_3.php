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
