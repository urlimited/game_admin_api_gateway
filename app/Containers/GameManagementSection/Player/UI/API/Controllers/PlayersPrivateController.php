<?php

namespace App\Containers\GameManagementSection\Player\UI\API\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Player\Actions\PlayerIndexAction;
use App\Containers\GameManagementSection\Player\Actions\PlayerShowAction;
use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\Player\UI\API\Requests\PlayerPrivateIndexRequest;
use App\Containers\GameManagementSection\Player\UI\API\Requests\PlayerPrivateShowRequest;
use App\Containers\GameManagementSection\Player\UI\API\Requests\PlayerPrivateStoreRequest;
use App\Containers\GameManagementSection\Player\UI\API\Requests\PlayerPrivateUpdateRequest;
use App\Containers\GameManagementSection\Player\UI\API\Transformers\PlayerAuthedTransformer;
use App\Containers\GameManagementSection\Player\UI\API\Transformers\PlayerTransformer;
use App\Containers\GameManagementSection\Player\Actions\PlayerStoreAction;
use App\Containers\GameManagementSection\Player\Actions\PlayerUpdateAction;
use App\Ship\Exceptions\AuthenticationException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class PlayersPrivateController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     */
    public function store(PlayerPrivateStoreRequest $request, Game $game): JsonResponse
    {
        $processedPlayer = app(PlayerStoreAction::class)->run($request);

        $preparedUserData = $this->transform($processedPlayer, PlayerAuthedTransformer::class);

        return response()->json($preparedUserData);
    }

    /**
     * @param PlayerPrivateUpdateRequest $request
     * @param Game $game
     * @param Player $player
     * @return JsonResponse
     * @throws AuthenticationException
     * @throws InvalidTransformerException
     * @throws RepositoryException
     * @throws ValidatorException
     */
    public function update(PlayerPrivateUpdateRequest $request, Game $game, Player $player): JsonResponse
    {
        $player = app(PlayerUpdateAction::class)->run($request);

        $preparedUserData = $this->transform($player, PlayerTransformer::class);

        return response()->json($preparedUserData);
    }

    /**
     * @throws InvalidTransformerException
     * @throws RepositoryException
     */
    public function index(PlayerPrivateIndexRequest $request, Game $game): JsonResponse
    {
        $player = app(PlayerIndexAction::class)->run($request);

        $preparedUserData = $this->transform($player, PlayerTransformer::class);

        return response()->json($preparedUserData);
    }

    /**
     * @throws InvalidTransformerException
     * @throws RepositoryException
     */
    public function show(PlayerPrivateShowRequest $request, Game $game, Player $player): JsonResponse
    {
        $player = app(PlayerShowAction::class)->run($request);

        $preparedUserData = $this->transform($player, PlayerTransformer::class);

        return response()->json($preparedUserData);
    }
}
