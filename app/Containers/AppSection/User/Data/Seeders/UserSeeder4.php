<?php

namespace App\Containers\AppSection\User\Data\Seeders;

use App\Containers\AppSection\Permission\Models\Permission;
use App\Containers\AppSection\Role\Models\Role;
use Illuminate\Database\Seeder;
use App\Containers\AppSection\User\Models\User;

class UserSeeder4 extends Seeder
{
    public function run()
    {
        $user = User::factory()->create([
            'login' => 'test',
            'password' => bcrypt('password'),
        ]);

        Role::query()
            ->whereIn('name', ['admin', 'common_customer'])
            ->get()
            ->each(fn($role) => $user->roles()->attach($role->getAttribute('id')));

        Permission::query()
            ->whereIn('name', ['game-full-own-read'])
            ->get()
            ->each(fn($permission) => $user->permissions()->attach($permission->getAttribute('id')));
    }
}
