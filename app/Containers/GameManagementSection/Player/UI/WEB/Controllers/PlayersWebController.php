<?php

namespace App\Containers\GameManagementSection\Player\UI\WEB\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Player\Actions\PlayerIndexAction;
use App\Containers\GameManagementSection\Player\Actions\PlayerShowAction;
use App\Containers\GameManagementSection\Player\Actions\PlayerStoreAction;
use App\Containers\GameManagementSection\Player\Actions\PlayerUpdateAction;
use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\Player\UI\WEB\Transformers\PlayerGeneralTransformer;
use App\Containers\GameManagementSection\Player\UI\WEB\Requests\PlayerWebIndexRequest;
use App\Containers\GameManagementSection\Player\UI\WEB\Requests\PlayerWebShowRequest;
use App\Containers\GameManagementSection\Player\UI\WEB\Requests\PlayerWebStoreRequest;
use App\Containers\GameManagementSection\Player\UI\WEB\Requests\PlayerWebUpdateRequest;
use App\Containers\GameManagementSection\Player\UI\WEB\Transformers\PlayerAuthedTransformer;
use App\Ship\Exceptions\AuthenticationException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class PlayersWebController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     */
    public function store(PlayerWebStoreRequest $request): JsonResponse
    {
        $processedPlayer = app(PlayerStoreAction::class)->run($request);

        $preparedUserData = $this->transform($processedPlayer, PlayerAuthedTransformer::class);

        return response()->json($preparedUserData);
    }

    /**
     * @param PlayerWebUpdateRequest $request
     * @param Player $player
     * @return JsonResponse
     * @throws AuthenticationException
     * @throws InvalidTransformerException
     * @throws RepositoryException
     * @throws ValidatorException
     */
    public function update(PlayerWebUpdateRequest $request, Player $player): JsonResponse
    {
        $player = app(PlayerUpdateAction::class)->run($request);

        $preparedUserData = $this->transform($player, PlayerGeneralTransformer::class);

        return response()->json($preparedUserData);
    }

    /**
     * @throws InvalidTransformerException
     * @throws RepositoryException
     */
    public function index(PlayerWebIndexRequest $request): JsonResponse
    {
        $player = app(PlayerIndexAction::class)->run($request);

        $preparedUserData = $this->transform($player, PlayerGeneralTransformer::class);

        return response()->json($preparedUserData);
    }

    /**
     * @throws InvalidTransformerException
     * @throws RepositoryException
     */
    public function show(PlayerWebShowRequest $request): JsonResponse
    {
        $player = app(PlayerShowAction::class)->run($request);

        $preparedUserData = $this->transform($player, PlayerGeneralTransformer::class);

        return response()->json($preparedUserData);
    }
}
