<?php

namespace App\Containers\AppSection\User\UI\API\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\User\Actions\UserIndexAction;
use App\Containers\AppSection\User\Actions\UserShowAction;
use App\Containers\AppSection\User\Actions\UserUpdateAction;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\UI\API\Requests\UserIndexRequest;
use App\Containers\AppSection\User\UI\API\Requests\UserShowRequest;
use App\Containers\AppSection\User\UI\API\Requests\UserUpdateRequest;
use App\Containers\AppSection\User\UI\API\Transformers\UserPrivateTransformer;
use App\Containers\AppSection\User\UI\API\Transformers\UserPublicTransformer;
use App\Containers\AppSection\User\Actions\UserCreateAction;
use App\Containers\AppSection\User\UI\API\Requests\UserStoreRequest;
use App\Ship\Exceptions\FilterResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Validator\Exceptions\ValidatorException;

class UsersController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        $user = app(UserCreateAction::class)->run($request);

        $preparedUserData = $this->transform($user, UserPublicTransformer::class);

        return response()->json($preparedUserData);
    }


    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     */
    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $user = app(UserUpdateAction::class)->run($request, $user);

        $preparedUserData = $this->transform($user, UserPublicTransformer::class);

        return response()->json($preparedUserData);
    }


    /**
     * @throws InvalidTransformerException
     * @throws FilterResourceFailedException
     */
    public function index(UserIndexRequest $request): JsonResponse
    {
        $users = app(UserIndexAction::class)->run($request);

        $preparedUserData = $this->transform($users, UserPublicTransformer::class);

        return response()->json($preparedUserData);
    }


    /**
     * @throws InvalidTransformerException
     * @throws FilterResourceFailedException
     */
    public function show(UserShowRequest $request): JsonResponse
    {
        $user = app(UserShowAction::class)->run($request);

        $preparedUserData = $this->transform($user, UserPrivateTransformer::class);

        return response()->json($preparedUserData);
    }
}
