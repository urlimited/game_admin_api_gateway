<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Tasks\FilterUsersTask;
use App\Containers\AppSection\User\UI\WEB\Requests\UserWebShowRequest;
use App\Ship\Exceptions\FilterResourceFailedException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Values\FilterValue;

class UserShowAction extends Action
{
    /**
     * @param UserWebShowRequest $request
     * @return User
     * @throws FilterResourceFailedException
     */
    public function run(UserWebShowRequest $request): User
    {
        return app(FilterUsersTask::class)
            ->run(
                [
                    new FilterValue(
                        key: 'id',
                        operator: '=',
                        value: $request->route('user_id')
                    )
                ]
            )
            ->first();
    }
}
