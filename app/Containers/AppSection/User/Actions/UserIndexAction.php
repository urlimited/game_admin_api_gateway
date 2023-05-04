<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FilterUsersTask;
use App\Containers\AppSection\User\UI\Web\Requests\UserWebIndexRequest;
use App\Ship\Exceptions\FilterResourceFailedException;
use App\Ship\Parents\Actions\Action;
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
