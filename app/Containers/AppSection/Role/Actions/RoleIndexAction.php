<?php

namespace App\Containers\AppSection\Role\Actions;

use App\Containers\AppSection\User\Tasks\FilterUserRolesTask;
use App\Ship\Exceptions\FilterResourceFailedException;
use App\Ship\Parents\Actions\Action;
use App\Containers\AppSection\Role\UI\WEB\Requests\RoleWebIndexRequest;
use Illuminate\Support\Collection;

class RoleIndexAction extends Action
{
    /**
     * @param RoleWebIndexRequest $request
     * @return Collection
     * @throws FilterResourceFailedException
     */
    public function run(RoleWebIndexRequest $request): Collection
    {
        return app(FilterUserRolesTask::class)->run();
    }
}
