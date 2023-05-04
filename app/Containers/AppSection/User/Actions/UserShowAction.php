<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FilterUsersTask;
use App\Containers\AppSection\User\UI\Web\Requests\UserWebShowRequest;
use App\Ship\Exceptions\FilterResourceFailedException;
use App\Ship\Parents\Actions\Action;
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
                        value: $request->route('user')
                    )
                ]
            )
            ->first();
    }
}
