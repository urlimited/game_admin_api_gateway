<?php

namespace App\Containers\AppSection\User\UI\WEB\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\User\UI\WEB\Requests\UserWebAuthRequest;
use App\Containers\AppSection\User\UI\WEB\Transformers\UserAuthTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthenticationWebController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     */
    public function auth(UserWebAuthRequest $request): JsonResponse|Response
    {
        if(!auth('api')->attempt(
            [
                'login' => $request->get('login'),
                'password' => $request->get('password')
            ]
        )) {
            return response()->noContent(401);
        }

        $request->session()->regenerate();

        $preparedUserData = $this->transform(auth('api')->user(), UserAuthTransformer::class);

        return response()->json($preparedUserData);
    }
}
