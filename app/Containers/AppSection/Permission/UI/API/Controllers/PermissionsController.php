<?php

namespace App\Containers\AppSection\Permission\UI\API\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Ship\Exceptions\FilterResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use App\Containers\AppSection\Permission\Actions\PermissionIndexAction;
use App\Containers\AppSection\Permission\UI\API\Requests\PermissionIndexRequest;
use App\Containers\AppSection\Permission\UI\API\Transformers\UserPermissionTransformer;
use Illuminate\Http\JsonResponse;

class PermissionsController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     * @throws FilterResourceFailedException
     */
    public function index(PermissionIndexRequest $request): JsonResponse
    {
        $roles = app(PermissionIndexAction::class)->run($request);

        $preparedUserData = $this->transform($roles, UserPermissionTransformer::class);

        return response()->json($preparedUserData);
    }
}
