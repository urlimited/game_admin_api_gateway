<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\UserStoreTask;
use App\Containers\AppSection\User\UI\Web\Requests\UserWebStoreRequest;
use App\Ship\Parents\Actions\Action;

class UserCreateAction extends Action
{
    public function run(UserWebStoreRequest $request): User
    {
        $validated = $request->validated();
        return app(UserStoreTask::class)
            ->run(
                login: $validated['login'],
                password: $validated['password'] ?? 'secret',
                roles: $validated['roles'],
                permissions:$validated['permissions'],
                status: $validated['status'],
            );
    }
}
