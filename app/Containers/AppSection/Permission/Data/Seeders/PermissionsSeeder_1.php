<?php

namespace App\Containers\AppSection\Permission\Data\Seeders;

use App\Containers\AppSection\Permission\Tasks\StorePermissionTask;
use Illuminate\Database\Seeder;

class PermissionsSeeder_1 extends Seeder
{
    public function run()
    {
        // CRUD
        $createPermissionTask = app(StorePermissionTask::class);

        // Games permissions
        $createPermissionTask->run('game-full-own-read', 'Can read full information regarding his own game');
        $createPermissionTask->run('game-full-other-read', 'Can read full information regarding all games');
        $createPermissionTask->run('game-public-own-read', 'Can read only public information regarding his games');
        $createPermissionTask->run('game-public-other-read', 'Can read only public information regarding all games');

        $createPermissionTask->run('game-full-own-update', 'Can update full information regarding his own game');
        $createPermissionTask->run('game-full-other-update', 'Can update full information regarding all games');
        $createPermissionTask->run('game-public-own-update', 'Can update only public information regarding his games');
        $createPermissionTask->run('game-public-other-update', 'Can update only public information regarding all games');

        $createPermissionTask->run('game-full-own-create', 'Can create a game with only personal owe');
        $createPermissionTask->run('game-full-other-create', 'Can create a game with whoever owe');

        $createPermissionTask->run('game-full-own-delete', 'Can delete a game belongs to him');
        $createPermissionTask->run('game-full-other-delete', 'Can delete a game belongs to whoever');

        // Players permissions
        $createPermissionTask->run('player-full-own-read', 'Can read full information regarding his own game players');
        $createPermissionTask->run('player-full-other-read', 'Can read full information regarding all games players');
        $createPermissionTask->run('player-public-own-read', 'Can read only public information regarding his games players');
        $createPermissionTask->run('player-public-other-read', 'Can read only public information regarding all games players');

        $createPermissionTask->run('player-full-own-update', 'Can update full information regarding his own game players');
        $createPermissionTask->run('player-full-other-update', 'Can update full information regarding all games players');
        $createPermissionTask->run('player-public-own-update', 'Can update only public information regarding his games players');
        $createPermissionTask->run('player-public-other-update', 'Can update only public information regarding all games players');

        $createPermissionTask->run('player-full-own-create', 'Can create a player with only personal owned game');
        $createPermissionTask->run('player-full-other-create', 'Can create a player with whoever owned games');

        $createPermissionTask->run('player-full-own-delete', 'Can delete a player belongs to his game');
        $createPermissionTask->run('player-full-other-delete', 'Can delete a player belongs to whoever\'s game');

        // Users permissions
        $createPermissionTask->run('user-full-own-read', 'Can read full information regarding his profile');
        $createPermissionTask->run('user-full-other-read', 'Can read full information regarding all profiles');
        $createPermissionTask->run('user-public-own-read', 'Can read only public information regarding his profile');
        $createPermissionTask->run('user-public-other-read', 'Can read only public information regarding all profiles');

        $createPermissionTask->run('user-full-own-update', 'Can update full information regarding his own profile');
        $createPermissionTask->run('user-full-other-update', 'Can update full information regarding all profiles');
        $createPermissionTask->run('user-public-own-update', 'Can update only public information regarding his profile');
        $createPermissionTask->run('user-public-other-update', 'Can update only public information regarding all profiles');

        $createPermissionTask->run('user-full-own-create', 'Can create a profile for himself');
        $createPermissionTask->run('user-full-other-create', 'Can create a profile to whoever-self');

        $createPermissionTask->run('user-full-own-delete', 'Can delete his profile');
        $createPermissionTask->run('user-full-other-delete', 'Can delete whoever\'s profile');
    }
}
