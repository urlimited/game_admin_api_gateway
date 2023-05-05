<?php

namespace App\Containers\ConfigurationSection\Configuration\UI\WEB\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\ConfigurationSection\Configuration\Actions\ConfigurationDeleteAction;
use App\Containers\ConfigurationSection\Configuration\Actions\ConfigurationIndexAction;
use App\Containers\ConfigurationSection\Configuration\Actions\ConfigurationShowAction;
use App\Containers\ConfigurationSection\Configuration\Actions\ConfigurationStoreAction;
use App\Containers\ConfigurationSection\Configuration\Actions\ConfigurationUpdateAction;
use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Configuration\UI\WEB\Requests\ConfigurationWebDeleteRequest;
use App\Containers\ConfigurationSection\Configuration\UI\WEB\Requests\ConfigurationWebIndexRequest;
use App\Containers\ConfigurationSection\Configuration\UI\WEB\Requests\ConfigurationWebShowRequest;
use App\Containers\ConfigurationSection\Configuration\UI\WEB\Requests\ConfigurationWebStoreRequest;
use App\Containers\ConfigurationSection\Configuration\UI\WEB\Requests\ConfigurationWebUpdateRequest;
use App\Containers\ConfigurationSection\Configuration\UI\WEB\Transformers\ConfigurationPrivateTransformer;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class ConfigurationsWebController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     */
    public function store(ConfigurationWebStoreRequest $request, Game $game): JsonResponse
    {
        $configuration = app(ConfigurationStoreAction::class)->run($request);

        $preparedStructureData = $this->transform($configuration, ConfigurationPrivateTransformer::class);

        return response()->json($preparedStructureData);
    }


    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     */
    public function update(ConfigurationWebUpdateRequest $request, Game $game, Configuration $configuration): JsonResponse
    {
        $configuration = app(ConfigurationUpdateAction::class)->run($request, $configuration);

        $preparedStructureData = $this->transform($configuration, ConfigurationPrivateTransformer::class);

        return response()->json($preparedStructureData);
    }


    public function delete(ConfigurationWebDeleteRequest $request, Game $game, Configuration $configuration): Response
    {

        app(ConfigurationDeleteAction::class)->run($configuration);

        return response()->noContent();
    }


    /**
     * @throws InvalidTransformerException
     */
    public function index(ConfigurationWebIndexRequest $request, Game $game): JsonResponse
    {
        $configuration = app(ConfigurationIndexAction::class)->run($request);

        $preparedStructureData = $this->transform($configuration, ConfigurationPrivateTransformer::class);

        return response()->json($preparedStructureData);
    }


    /**
     * @throws InvalidTransformerException
     */
    public function show(ConfigurationWebShowRequest $request, Game $game, Configuration $configuration): JsonResponse
    {
        $configuration = app(ConfigurationShowAction::class)->run($configuration);

        $preparedStructureData = $this->transform($configuration, ConfigurationPrivateTransformer::class);

        return response()->json($preparedStructureData);
    }
}
