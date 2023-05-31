<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Tasks\UserUpdateTask;
use App\Containers\AppSection\User\UI\WEB\Requests\UserWebUpdateRequest;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Models\User;
use Illuminate\Support\Facades\Hash;
use Prettus\Validator\Exceptions\ValidatorException;

class UserUpdateAction extends Action
{
    /**
     * @throws ValidatorException
     */
    public function run(UserWebUpdateRequest $request, User $user): User
    {
        $validated = $request->validated();

        if (array_key_exists('password', $validated)) {
            $validated['password'] = Hash::make($validated['password']);
        }

        return app(UserUpdateTask::class)
            ->run($user->getAttribute('id'), $validated);
    }
}
