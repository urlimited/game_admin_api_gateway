<?php

namespace App\Containers\AppSection\Role\Actions;

use App\Containers\AppSection\User\Tasks\FilterUserRolesTask;
use App\Ship\Exceptions\FilterResourceFailedException;
use App\Ship\Parents\Actions\Action;
use App\Containers\AppSection\Role\UI\API\Requests\RoleIndexRequest;
use Illuminate\Support\Collection;

class RoleIndexAction extends Action
{
    /**
     * @param RoleIndexRequest $request
     * @return Collection
     * @throws FilterResourceFailedException
     */
    public function run(RoleIndexRequest $request): Collection
    {
        return app(FilterUserRolesTask::class)->run();
    }
}
