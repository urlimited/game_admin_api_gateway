<?php

namespace App\Containers\AppSection\Role\UI\API\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Ship\Exceptions\FilterResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use App\Containers\AppSection\Role\Actions\RoleIndexAction;
use App\Containers\AppSection\Role\UI\API\Requests\RoleIndexRequest;
use App\Containers\AppSection\Role\UI\API\Transformers\UserRoleTransformer;
use Illuminate\Http\JsonResponse;

class RolesController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     * @throws FilterResourceFailedException
     */
    public function index(RoleIndexRequest $request): JsonResponse
    {
        $roles = app(RoleIndexAction::class)->run($request);

        $preparedUserData = $this->transform($roles, UserRoleTransformer::class);

        return response()->json($preparedUserData);
    }
}
