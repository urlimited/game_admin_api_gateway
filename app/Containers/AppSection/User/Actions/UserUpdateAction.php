<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Permission\Models\Permission;
use App\Containers\AppSection\Role\Models\Role;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\UserUpdateTask;
use App\Containers\AppSection\User\UI\API\Requests\UserUpdateRequest;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;

class UserUpdateAction extends Action
{
    /**
     * @throws ValidatorException
     */
    public function run(UserUpdateRequest $request, User $user): User
    {
        $validated = $request->validated();

        return app(UserUpdateTask::class)
            ->run(id: $user->id,
                status: $validated['status'],
                roles: $validated['roles'],
                permissions: $validated['permissions'],
            );
    }
}
