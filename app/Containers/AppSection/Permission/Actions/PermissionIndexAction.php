<?php

namespace App\Containers\AppSection\Permission\Actions;

use App\Containers\AppSection\User\Tasks\FilterUserPermissionsTask;
use App\Ship\Exceptions\FilterResourceFailedException;
use App\Ship\Parents\Actions\Action;
use App\Containers\AppSection\Permission\UI\API\Requests\PermissionIndexRequest;
use Illuminate\Support\Collection;

class PermissionIndexAction extends Action
{
    /**
     * @param PermissionIndexRequest $request
     * @return Collection
     * @throws FilterResourceFailedException
     */
    public function run(PermissionIndexRequest $request): Collection
    {
        return app(FilterUserPermissionsTask::class)->run();
    }
}
