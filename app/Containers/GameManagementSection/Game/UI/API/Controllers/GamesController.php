<?php

namespace App\Containers\GameManagementSection\Game\UI\API\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\GameManagementSection\Game\Actions\GameIndexAction;
use App\Containers\GameManagementSection\Game\Actions\GameShowAction;
use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\UI\API\Requests\GameApiTokenReCreateRequest;
use App\Containers\GameManagementSection\Game\UI\API\Requests\GameIndexRequest;
use App\Containers\GameManagementSection\Game\UI\API\Requests\GameShowRequest;
use App\Containers\GameManagementSection\Game\UI\API\Requests\GameStoreRequest;
use App\Containers\GameManagementSection\Game\UI\API\Requests\GameDeleteRequest;
use App\Containers\GameManagementSection\Game\UI\API\Requests\GameUpdateRequest;
use App\Containers\GameManagementSection\Game\UI\API\Transformers\GameCreatedTransformer;
use App\Containers\GameManagementSection\Game\Actions\GameApiTokenReCreateAction;
use App\Containers\GameManagementSection\Game\Actions\GameStoreAction;
use App\Containers\GameManagementSection\Game\Actions\GameDeleteAction;
use App\Containers\GameManagementSection\Game\Actions\GameUpdateAction;
use App\Containers\GameManagementSection\Game\UI\API\Transformers\GamePrivateTransformer;
use App\Containers\GameManagementSection\Game\UI\API\Transformers\GamePublicTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class GamesController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     */
    public function store(GameStoreRequest $request): JsonResponse
    {
        $game = app(GameStoreAction::class)->run($request);

        $preparedUserData = $this->transform($game, GameCreatedTransformer::class);

        return response()->json($preparedUserData);
    }

    /**
     * @throws InvalidTransformerException
     */
    public function reCreateApiToken(GameApiTokenReCreateRequest $request, Game $game): JsonResponse
    {
        $game = app(GameApiTokenReCreateAction::class)->run($request, $game);

        $preparedUserData = $this->transform($game, GameCreatedTransformer::class);

        return response()->json($preparedUserData);
    }


    public function update(GameUpdateRequest $request, Game $game): JsonResponse
    {
        $game = app(GameUpdateAction::class)->run($request, $game);

        $preparedUserData = $this->transform($game, GamePrivateTransformer::class);

        return response()->json($preparedUserData);
    }


    public function delete(GameDeleteRequest $request, Game $game): Response
    {
        app(GameDeleteAction::class)->run($request, $game);

        return response()->noContent();
    }

    public function index(GameIndexRequest $request)
    {
        $games = app(GameIndexAction::class)->run($request);

        $preparedUserData = $this->transform($games, GamePublicTransformer::class);

        return response()->json($preparedUserData);
    }

    public function show(GameShowRequest $request, Game $game): JsonResponse
    {
        $game = app(GameShowAction::class)->run($request, $game);

        $preparedUserData = $this->transform($game, GamePublicTransformer::class);

        return response()->json($preparedUserData);
    }
}
