<?php

namespace App\Containers\AppSection\User\Data\Seeders;

use App\Ship\Parents\Models\Permission;
use App\Ship\Parents\Models\Role;
use App\Ship\Parents\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder4 extends Seeder
{
    public function run()
    {
        /**
         * @var User $user
         */
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
