<?php

namespace App\Containers\ConfigurationSection\Configuration\UI\API\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\ConfigurationSection\Configuration\Actions\ConfigurationDeleteAction;
use App\Containers\ConfigurationSection\Configuration\Actions\ConfigurationIndexAction;
use App\Containers\ConfigurationSection\Configuration\Actions\ConfigurationShowAction;
use App\Containers\ConfigurationSection\Configuration\Actions\ConfigurationStoreAction;
use App\Containers\ConfigurationSection\Configuration\Actions\ConfigurationUpdateAction;
use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Configuration\UI\API\Requests\ConfigurationPrivateDeleteRequest;
use App\Containers\ConfigurationSection\Configuration\UI\API\Requests\ConfigurationPrivateIndexRequest;
use App\Containers\ConfigurationSection\Configuration\UI\API\Requests\ConfigurationPrivateShowRequest;
use App\Containers\ConfigurationSection\Configuration\UI\API\Requests\ConfigurationPrivateStoreRequest;
use App\Containers\ConfigurationSection\Configuration\UI\API\Requests\ConfigurationPrivateUpdateRequest;
use App\Containers\ConfigurationSection\Configuration\UI\API\Transformers\ConfigurationPrivateTransformer;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Http\Response;

class ConfigurationsPrivateController extends ApiController
{

    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     */
    public function store(ConfigurationPrivateStoreRequest $request, Game $game): JsonResponse
    {
        $configuration = app(ConfigurationStoreAction::class)->run($request);

        $preparedStructureData = $this->transform($configuration, ConfigurationPrivateTransformer::class);

        return response()->json($preparedStructureData);
    }


    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     */
    public function update(ConfigurationPrivateUpdateRequest $request, Game $game, Configuration $configuration): JsonResponse
    {
        $configuration = app(ConfigurationUpdateAction::class)->run($request, $configuration);

        $preparedStructureData = $this->transform($configuration, ConfigurationPrivateTransformer::class);

        return response()->json($preparedStructureData);
    }


    public function delete(ConfigurationPrivateDeleteRequest $request, Game $game, Configuration $configuration): Response
    {

        app(ConfigurationDeleteAction::class)->run($configuration);

        return response()->noContent();
    }


    /**
     * @throws InvalidTransformerException
     */
    public function index(ConfigurationPrivateIndexRequest $request, Game $game): JsonResponse
    {
        $configuration = app(ConfigurationIndexAction::class)->run($request);

        $preparedStructureData = $this->transform($configuration, ConfigurationPrivateTransformer::class);

        return response()->json($preparedStructureData);
    }


    /**
     * @throws InvalidTransformerException
     */
    public function show(ConfigurationPrivateShowRequest $request, Game $game, Configuration $configuration): JsonResponse
    {
        $configuration = app(ConfigurationShowAction::class)->run($configuration);

        $preparedStructureData = $this->transform($configuration, ConfigurationPrivateTransformer::class);

        return response()->json($preparedStructureData);
    }
}
