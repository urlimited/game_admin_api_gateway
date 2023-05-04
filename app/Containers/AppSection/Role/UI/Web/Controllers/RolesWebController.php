<?php

namespace App\Containers\AppSection\Role\UI\Web\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Ship\Exceptions\FilterResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use App\Containers\AppSection\Role\Actions\RoleIndexAction;
use App\Containers\AppSection\Role\UI\Web\Requests\RoleWebIndexRequest;
use App\Containers\AppSection\Role\UI\Web\Transformers\UserRoleTransformer;
use Illuminate\Http\JsonResponse;

class RolesWebController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     * @throws FilterResourceFailedException
     */
    public function index(RoleWebIndexRequest $request): JsonResponse
    {
        $roles = app(RoleIndexAction::class)->run($request);

        $preparedUserData = $this->transform($roles, UserRoleTransformer::class);

        return response()->json($preparedUserData);
    }
}
