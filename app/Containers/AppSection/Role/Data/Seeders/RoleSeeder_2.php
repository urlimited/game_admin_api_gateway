<?php

namespace App\Containers\AppSection\Role\Data\Seeders;

use App\Containers\AppSection\Role\Tasks\StoreRoleTask;
use Illuminate\Database\Seeder;

class RoleSeeder_2 extends Seeder
{
    public function run()
    {
        app(StoreRoleTask::class)->run('admin', 'Administrator', 'Administrator Role');
        app(StoreRoleTask::class)->run('common_customer', 'Common system user', 'Common Customer Role');
        app(StoreRoleTask::class)->run('privileged_customer', 'System user with privileges', 'Privileged Customer Role');
        app(StoreRoleTask::class)->run('guest', 'Unauthorized user', 'Guest Role');
    }
}
