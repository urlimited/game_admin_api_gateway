<?php

namespace App\Containers\GameManagementSection\Player\UI\API\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\GameManagementSection\Player\Actions\PlayerAuthAction;
use App\Containers\GameManagementSection\Player\Actions\PlayerShowAction;
use App\Containers\GameManagementSection\Player\Actions\PlayerStoreAction;
use App\Containers\GameManagementSection\Player\Actions\PlayerUpdateAction;
use App\Containers\GameManagementSection\Player\UI\API\Requests\PlayerApiAuthRequest;
use App\Containers\GameManagementSection\Player\UI\API\Requests\PlayerApiShowRequest;
use App\Containers\GameManagementSection\Player\UI\API\Requests\PlayerApiStoreRequest;
use App\Containers\GameManagementSection\Player\UI\API\Requests\PlayerApiUpdateRequest;
use App\Containers\GameManagementSection\Player\UI\API\Transformers\PlayerTransformer;
use App\Containers\GameManagementSection\Player\UI\WEB\Transformers\PlayerAuthedTransformer;
use App\Ship\Exceptions\AuthenticationException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class PlayersApiController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     */
    public function store(PlayerApiStoreRequest $request): JsonResponse
    {
        $processedGame = app(PlayerStoreAction::class)->run($request);

        $preparedUserData = $this->transform($processedGame, PlayerAuthedTransformer::class);

        return response()->json($preparedUserData);
    }

    /**
     * @param PlayerApiUpdateRequest $request
     * @return JsonResponse
     * @throws AuthenticationException
     * @throws InvalidTransformerException
     * @throws RepositoryException
     * @throws ValidatorException
     */
    public function update(PlayerApiUpdateRequest $request): JsonResponse
    {
        $player = app(PlayerUpdateAction::class)->run($request);

        $preparedUserData = $this->transform($player, PlayerTransformer::class);

        return response()->json($preparedUserData);
    }

    /**
     * @throws InvalidTransformerException
     * @throws RepositoryException
     */
    public function show(PlayerApiShowRequest $request): JsonResponse
    {
        $player = app(PlayerShowAction::class)->run($request);

        $preparedUserData = $this->transform($player, PlayerTransformer::class);

        return response()->json($preparedUserData);
    }


    /**
     * @throws InvalidTransformerException
     * @throws RepositoryException
     * @throws AuthenticationException
     */
    public function auth(PlayerApiAuthRequest $request): JsonResponse
    {
        $player = app(PlayerAuthAction::class)->run($request);

        $preparedUserData = $this->transform($player, PlayerAuthedTransformer::class);

        return response()->json($preparedUserData);
    }
}
