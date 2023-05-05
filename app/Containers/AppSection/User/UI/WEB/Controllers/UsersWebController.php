<?php

namespace App\Containers\AppSection\User\UI\WEB\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\User\Actions\UserIndexAction;
use App\Containers\AppSection\User\Actions\UserShowAction;
use App\Containers\AppSection\User\Actions\UserUpdateAction;
use App\Containers\AppSection\User\UI\WEB\Requests\UserWebIndexRequest;
use App\Containers\AppSection\User\UI\WEB\Requests\UserWebShowRequest;
use App\Containers\AppSection\User\UI\WEB\Requests\UserWebUpdateRequest;
use App\Containers\AppSection\User\UI\WEB\Transformers\UserPrivateTransformer;
use App\Containers\AppSection\User\UI\WEB\Transformers\UserPublicTransformer;
use App\Containers\AppSection\User\Actions\UserCreateAction;
use App\Containers\AppSection\User\UI\WEB\Requests\UserWebStoreRequest;
use App\Ship\Exceptions\FilterResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use App\Ship\Parents\Models\User;
use Illuminate\Http\JsonResponse;
use Prettus\Validator\Exceptions\ValidatorException;

class UsersWebController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     */
    public function store(UserWebStoreRequest $request): JsonResponse
    {
        $user = app(UserCreateAction::class)->run($request);

        $preparedUserData = $this->transform($user, UserPublicTransformer::class);

        return response()->json($preparedUserData);
    }


    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     */
    public function update(UserWebUpdateRequest $request, User $user): JsonResponse
    {
        $user = app(UserUpdateAction::class)->run($request, $user);

        $preparedUserData = $this->transform($user, UserPublicTransformer::class);

        return response()->json($preparedUserData);
    }


    /**
     * @throws InvalidTransformerException
     * @throws FilterResourceFailedException
     */
    public function index(UserWebIndexRequest $request): JsonResponse
    {
        $users = app(UserIndexAction::class)->run($request);

        $preparedUserData = $this->transform($users, UserPublicTransformer::class);

        return response()->json($preparedUserData);
    }


    /**
     * @throws InvalidTransformerException
     * @throws FilterResourceFailedException
     */
    public function show(UserWebShowRequest $request): JsonResponse
    {
        $user = app(UserShowAction::class)->run($request);

        $preparedUserData = $this->transform($user, UserPrivateTransformer::class);

        return response()->json($preparedUserData);
    }
}
