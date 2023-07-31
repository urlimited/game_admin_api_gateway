<?php

namespace App\Containers\AppSection\Permission\Data\Seeders;

use App\Containers\AppSection\Permission\Tasks\AttachPermissionsToRoleTask;
use App\Containers\AppSection\Permission\Tasks\StorePermissionTask;
use Illuminate\Database\Seeder;

class PermissionsToRolesTargetGroupsSeeder_6 extends Seeder
{
    public function run()
    {
        $createPermissionTask = app(StorePermissionTask::class);

        // Target group
        $createPermissionTask->run('target-group-full-own-read', 'Can read full target group information regarding his own game');
        $createPermissionTask->run('target-group-full-other-read', 'Can read full target group information regarding all games');

        $createPermissionTask->run('target-group-full-own-update', 'Can update full target group information regarding his own game');
        $createPermissionTask->run('target-group-full-other-update', 'Can update full target group information regarding all games');

        $createPermissionTask->run('target-group-full-own-create', 'Can create a target group to the game that belongs to him');
        $createPermissionTask->run('target-group-full-other-create', 'Can create a target group to the game with whoever owe');

        $createPermissionTask->run('target-group-full-own-delete', 'Can delete a target group of the game belongs to him');
        $createPermissionTask->run('target-group-full-other-delete', 'Can delete a target group of the game belongs to whoever');


        // Target group data
        $createPermissionTask->run('target-group-data-full-own-read', 'Can read full stat data information regarding his own game');
        $createPermissionTask->run('target-group-data-full-other-read', 'Can read full stat data information regarding all games');

        $createPermissionTask->run('target-group-data-full-own-update', 'Can update full stat data information regarding his own game');
        $createPermissionTask->run('target-group-data-full-other-update', 'Can update full stat data information regarding all games');

        $createPermissionTask->run('target-group-data-full-own-create', 'Can create a stat data to the game with only personal owe');
        $createPermissionTask->run('target-group-data-full-other-create', 'Can create a stat data to the game with whoever owe');

        $createPermissionTask->run('target-group-data-full-own-delete', 'Can delete a stat data of the game belongs to him');
        $createPermissionTask->run('target-group-data-full-other-delete', 'Can delete a stat data of the game belongs to whoever');

        // Link permissions to the roles
        app(AttachPermissionsToRoleTask::class)
            ->run(
                'admin',
                [
                    'target-group-full-own-read',
                    'target-group-full-other-read',
                    'target-group-full-own-update',
                    'target-group-full-other-update',
                    'target-group-full-own-create',
                    'target-group-full-other-create',
                    'target-group-full-own-delete',
                    'target-group-full-other-delete',

                    'target-group-data-full-own-read',
                    'target-group-data-full-other-read',
                    'target-group-data-full-own-update',
                    'target-group-data-full-other-update',
                    'target-group-data-full-own-create',
                    'target-group-data-full-other-create',
                    'target-group-data-full-own-delete',
                    'target-group-data-full-other-delete',
                ]
            );

        app(AttachPermissionsToRoleTask::class)
            ->run(
                'common_customer',
                [
                    'target-group-full-own-read',
                    'target-group-full-own-update',
                    'target-group-full-own-create',
                    'target-group-full-own-delete',

                    'target-group-data-full-own-read',
                    'target-group-data-full-own-update',
                    'target-group-data-full-own-create',
                    'target-group-data-full-own-delete',
                ]
            );

        app(AttachPermissionsToRoleTask::class)
            ->run(
                'privileged_customer',
                [
                    'target-group-full-own-read',
                    'target-group-full-own-update',
                    'target-group-full-own-create',
                    'target-group-full-own-delete',

                    'target-group-data-full-own-read',
                    'target-group-data-full-own-update',
                    'target-group-data-full-own-create',
                    'target-group-data-full-own-delete',
                ]
            );
    }
}
