<?php

namespace App\Containers\AppSection\User\UI\WEB\Controllers;

use App\Containers\AppSection\User\Actions\UserRegisterAction;
use App\Containers\AppSection\User\UI\WEB\Requests\UserWebRegisterRequest;
use App\Containers\AppSection\User\UI\WEB\Transformers\UserAuthTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class RegistrationWebController extends ApiController
{
    public function register(UserWebRegisterRequest $request): JsonResponse
    {
        $user = app(UserRegisterAction::class)->run($request);
        auth('api')->login($user);

        $request->session()->regenerate();

        $preparedUserData = $this->transform($user, UserAuthTransformer::class);
        return response()->json($preparedUserData);
    }
}
