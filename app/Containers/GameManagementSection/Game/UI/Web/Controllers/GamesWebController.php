<?php

namespace App\Containers\GameManagementSection\Game\UI\Web\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\GameManagementSection\Game\Actions\GameIndexAction;
use App\Containers\GameManagementSection\Game\Actions\GameShowAction;
use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Game\UI\Web\Requests\GameWebApiTokenReCreateRequest;
use App\Containers\GameManagementSection\Game\UI\Web\Requests\GameWebIndexRequest;
use App\Containers\GameManagementSection\Game\UI\Web\Requests\GameWebShowRequest;
use App\Containers\GameManagementSection\Game\UI\Web\Requests\GameWebStoreRequest;
use App\Containers\GameManagementSection\Game\UI\Web\Requests\GameWebDeleteRequest;
use App\Containers\GameManagementSection\Game\UI\Web\Requests\GameWebUpdateRequest;
use App\Containers\GameManagementSection\Game\UI\Web\Transformers\GameCreatedTransformer;
use App\Containers\GameManagementSection\Game\Actions\GameApiTokenReCreateAction;
use App\Containers\GameManagementSection\Game\Actions\GameStoreAction;
use App\Containers\GameManagementSection\Game\Actions\GameDeleteAction;
use App\Containers\GameManagementSection\Game\Actions\GameUpdateAction;
use App\Containers\GameManagementSection\Game\UI\Web\Transformers\GamePrivateTransformer;
use App\Containers\GameManagementSection\Game\UI\Web\Transformers\GamePublicTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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

    public function index(GameWebIndexRequest $request)
    {
        $games = app(GameIndexAction::class)->run($request);

        $preparedUserData = $this->transform($games, GamePublicTransformer::class);

        return response()->json($preparedUserData);
    }

    public function show(GameWebShowRequest $request, Game $game): JsonResponse
    {
        $game = app(GameShowAction::class)->run($request, $game);

        $preparedUserData = $this->transform($game, GamePublicTransformer::class);

        return response()->json($preparedUserData);
    }
}
