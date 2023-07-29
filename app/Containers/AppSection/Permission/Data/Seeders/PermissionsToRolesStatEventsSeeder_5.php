<?php

namespace App\Containers\AppSection\Permission\Data\Seeders;

use App\Containers\AppSection\Permission\Tasks\AttachPermissionsToRoleTask;
use App\Containers\AppSection\Permission\Tasks\StorePermissionTask;
use Illuminate\Database\Seeder;

class PermissionsToRolesStatEventsSeeder_5 extends Seeder
{
    public function run()
    {
        $createPermissionTask = app(StorePermissionTask::class);

        // Stat event
        $createPermissionTask->run('stat-event-full-own-read', 'Can read full stat event information regarding his own game');
        $createPermissionTask->run('stat-event-full-other-read', 'Can read full stat event information regarding all games');

        $createPermissionTask->run('stat-event-full-own-update', 'Can update full stat event information regarding his own game');
        $createPermissionTask->run('stat-event-full-other-update', 'Can update full stat event information regarding all games');

        $createPermissionTask->run('stat-event-full-own-create', 'Can create a stat event to the game that belongs to him');
        $createPermissionTask->run('stat-event-full-other-create', 'Can create a stat event to the game with whoever owe');

        $createPermissionTask->run('stat-event-full-own-delete', 'Can delete a stat event of the game belongs to him');
        $createPermissionTask->run('stat-event-full-other-delete', 'Can delete a stat event of the game belongs to whoever');


        // Stat event data
        $createPermissionTask->run('stat-event-data-full-own-read', 'Can read full stat data information regarding his own game');
        $createPermissionTask->run('stat-event-data-full-other-read', 'Can read full stat data information regarding all games');

        $createPermissionTask->run('stat-event-data-full-own-update', 'Can update full stat data information regarding his own game');
        $createPermissionTask->run('stat-event-data-full-other-update', 'Can update full stat data information regarding all games');

        $createPermissionTask->run('stat-event-data-full-own-create', 'Can create a stat data to the game with only personal owe');
        $createPermissionTask->run('stat-event-data-full-other-create', 'Can create a stat data to the game with whoever owe');

        $createPermissionTask->run('stat-event-data-full-own-delete', 'Can delete a stat data of the game belongs to him');
        $createPermissionTask->run('stat-event-data-full-other-delete', 'Can delete a stat data of the game belongs to whoever');

        // Link permissions to the roles
        app(AttachPermissionsToRoleTask::class)
            ->run(
                'admin',
                [
                    'stat-event-full-own-read',
                    'stat-event-full-other-read',
                    'stat-event-full-own-update',
                    'stat-event-full-other-update',
                    'stat-event-full-own-create',
                    'stat-event-full-other-create',
                    'stat-event-full-own-delete',
                    'stat-event-full-other-delete',

                    'stat-event-data-full-own-read',
                    'stat-event-data-full-other-read',
                    'stat-event-data-full-own-update',
                    'stat-event-data-full-other-update',
                    'stat-event-data-full-own-create',
                    'stat-event-data-full-other-create',
                    'stat-event-data-full-own-delete',
                    'stat-event-data-full-other-delete',
                ]
            );

        app(AttachPermissionsToRoleTask::class)
            ->run(
                'common_customer',
                [
                    'stat-event-full-own-read',
                    'stat-event-full-own-update',
                    'stat-event-full-own-create',
                    'stat-event-full-own-delete',

                    'stat-event-data-full-own-read',
                    'stat-event-data-full-own-update',
                    'stat-event-data-full-own-create',
                    'stat-event-data-full-own-delete',
                ]
            );

        app(AttachPermissionsToRoleTask::class)
            ->run(
                'privileged_customer',
                [
                    'stat-event-full-own-read',
                    'stat-event-full-own-update',
                    'stat-event-full-own-create',
                    'stat-event-full-own-delete',

                    'stat-event-data-full-own-read',
                    'stat-event-data-full-own-update',
                    'stat-event-data-full-own-create',
                    'stat-event-data-full-own-delete',
                ]
            );
    }
}
