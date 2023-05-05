<?php

namespace App\Containers\AppSection\Permission\UI\WEB\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Ship\Exceptions\FilterResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use App\Containers\AppSection\Permission\Actions\PermissionIndexAction;
use App\Containers\AppSection\Permission\UI\WEB\Requests\PermissionWebIndexRequest;
use App\Containers\AppSection\Permission\UI\WEB\Transformers\UserPermissionTransformer;
use Illuminate\Http\JsonResponse;

class PermissionsWebController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     * @throws FilterResourceFailedException
     */
    public function index(PermissionWebIndexRequest $request): JsonResponse
    {
        $roles = app(PermissionIndexAction::class)->run($request);

        $preparedUserData = $this->transform($roles, UserPermissionTransformer::class);

        return response()->json($preparedUserData);
    }
}
