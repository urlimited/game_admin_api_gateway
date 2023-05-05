<?php

namespace App\Containers\GameManagementSection\Game\UI\WEB\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\GameManagementSection\Game\Actions\GameIndexAction;
use App\Containers\GameManagementSection\Game\Actions\GameShowAction;
use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\UI\WEB\Requests\GameWebApiTokenReCreateRequest;
use App\Containers\GameManagementSection\Game\UI\WEB\Requests\GameWebIndexRequest;
use App\Containers\GameManagementSection\Game\UI\WEB\Requests\GameWebShowRequest;
use App\Containers\GameManagementSection\Game\UI\WEB\Requests\GameWebStoreRequest;
use App\Containers\GameManagementSection\Game\UI\WEB\Requests\GameWebDeleteRequest;
use App\Containers\GameManagementSection\Game\UI\WEB\Requests\GameWebUpdateRequest;
use App\Containers\GameManagementSection\Game\UI\WEB\Transformers\GameCreatedTransformer;
use App\Containers\GameManagementSection\Game\Actions\GameApiTokenReCreateAction;
use App\Containers\GameManagementSection\Game\Actions\GameStoreAction;
use App\Containers\GameManagementSection\Game\Actions\GameDeleteAction;
use App\Containers\GameManagementSection\Game\Actions\GameUpdateAction;
use App\Containers\GameManagementSection\Game\UI\WEB\Transformers\GamePrivateTransformer;
use App\Containers\GameManagementSection\Game\UI\WEB\Transformers\GamePublicTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class GamesWebController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     */
    public function store(GameWebStoreRequest $request): JsonResponse
    {
        $game = app(GameStoreAction::class)->run($request);

        $preparedUserData = $this->transform($game, GameCreatedTransformer::class);

        return response()->json($preparedUserData);
    }

    /**
     * @throws InvalidTransformerException
     */
    public function reCreateApiToken(GameWebApiTokenReCreateRequest $request, Game $game): JsonResponse
    {
        $game = app(GameApiTokenReCreateAction::class)->run($request, $game);

        $preparedUserData = $this->transform($game, GameCreatedTransformer::class);

        return response()->json($preparedUserData);
    }


    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     */
    public function update(GameWebUpdateRequest $request, Game $game): JsonResponse
    {
        $game = app(GameUpdateAction::class)->run($request, $game);

        $preparedUserData = $this->transform($game, GamePrivateTransformer::class);

        return response()->json($preparedUserData);
    }


    public function delete(GameWebDeleteRequest $request, Game $game): Response
    {
        app(GameDeleteAction::class)->run($request, $game);

        return response()->noContent();
    }

    /**
     * @throws InvalidTransformerException
     */
    public function index(GameWebIndexRequest $request): JsonResponse
    {
        $games = app(GameIndexAction::class)->run($request);

        $preparedUserData = $this->transform($games, GamePublicTransformer::class);

        return response()->json($preparedUserData);
    }

    public function show(GameWebShowRequest $request): JsonResponse
    {
        $game = app(GameShowAction::class)->run($request);

        $preparedUserData = $this->transform($game, GamePublicTransformer::class);

        return response()->json($preparedUserData);
    }
}
