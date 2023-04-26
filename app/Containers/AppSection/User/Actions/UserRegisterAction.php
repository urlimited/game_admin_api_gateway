<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Role\Models\Role;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\UserStoreTask;
use App\Containers\AppSection\User\UI\API\Requests\UserStoreRequest;
use App\Ship\Parents\Actions\Action;

class UserRegisterAction extends Action
{
    public function run(UserStoreRequest $request): User
    {
        $roleId = Role::query()
            ->where('name','common_customer')
            ->value('id');

        $validated = $request->validated();

        return app(UserStoreTask::class)
            ->run(
                login: $validated['login'],
                password: $validated['password'],
                roles: [$roleId],
                permissions:[],
                status: $validated['status'],
            );
    }
}
