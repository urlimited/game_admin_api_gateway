<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Tasks\FilterUsersTask;
use App\Containers\AppSection\User\UI\WEB\Requests\UserWebIndexRequest;
use App\Ship\Exceptions\FilterResourceFailedException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Models\User;
use Illuminate\Support\Collection;

class UserIndexAction extends Action
{
    /**
     * @param UserWebIndexRequest $request
     * @return Collection<User>
     * @throws FilterResourceFailedException
     */
    public function run(UserWebIndexRequest $request): Collection
    {
        return app(FilterUsersTask::class)->run();
    }
}
