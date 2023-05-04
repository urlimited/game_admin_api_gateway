<?php

namespace App\Containers\AppSection\Permission\Actions;

use App\Containers\AppSection\User\Tasks\FilterUserPermissionsTask;
use App\Ship\Exceptions\FilterResourceFailedException;
use App\Ship\Parents\Actions\Action;
use App\Containers\AppSection\Permission\UI\Web\Requests\PermissionWebIndexRequest;
use Illuminate\Support\Collection;

class PermissionIndexAction extends Action
{
    /**
     * @param PermissionWebIndexRequest $request
     * @return Collection
     * @throws FilterResourceFailedException
     */
    public function run(PermissionWebIndexRequest $request): Collection
    {
        return app(FilterUserPermissionsTask::class)->run();
    }
}
