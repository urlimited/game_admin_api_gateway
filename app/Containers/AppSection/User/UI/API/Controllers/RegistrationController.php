<?php

namespace App\Containers\AppSection\User\UI\API\Controllers;

use App\Containers\AppSection\User\Actions\UserRegisterAction;
use App\Containers\AppSection\User\UI\API\Requests\UserRegisterRequest;
use App\Containers\AppSection\User\UI\API\Transformers\UserAuthTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class RegistrationController extends ApiController
{
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $user = app(UserRegisterAction::class)->run($request);
        auth('api')->login($user);

        $request->session()->regenerate();

        $preparedUserData = $this->transform($user, UserAuthTransformer::class);
        return response()->json($preparedUserData);
    }
}
