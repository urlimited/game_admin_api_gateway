<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FilterUsersTask;
use App\Containers\AppSection\User\UI\API\Requests\UserIndexRequest;
use App\Ship\Exceptions\FilterResourceFailedException;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class UserIndexAction extends Action
{
    /**
     * @param UserIndexRequest $request
     * @return Collection<User>
     * @throws FilterResourceFailedException
     */
    public function run(UserIndexRequest $request): Collection
    {
        return app(FilterUsersTask::class)->run();
    }
}
