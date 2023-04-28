<?php

namespace App\Containers\ConfigurationSection\Configuration\UI\API\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\ConfigurationSection\Configuration\Actions\ConfigurationDeleteAction;
use App\Containers\ConfigurationSection\Configuration\Actions\ConfigurationIndexAction;
use App\Containers\ConfigurationSection\Configuration\Actions\ConfigurationShowAction;
use App\Containers\ConfigurationSection\Configuration\Actions\ConfigurationStoreAction;
use App\Containers\ConfigurationSection\Configuration\Actions\ConfigurationUpdateAction;
use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Configuration\UI\API\Requests\ConfigurationDeleteRequest;
use App\Containers\ConfigurationSection\Configuration\UI\API\Requests\ConfigurationIndexRequest;
use App\Containers\ConfigurationSection\Configuration\UI\API\Requests\ConfigurationShowRequest;
use App\Containers\ConfigurationSection\Configuration\UI\API\Requests\ConfigurationStoreRequest;
use App\Containers\ConfigurationSection\Configuration\UI\API\Requests\ConfigurationUpdateRequest;
use App\Containers\ConfigurationSection\Configuration\UI\API\Transformers\ConfigurationTransformer;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Exceptions\InvalidDataProvidedForRuleException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Http\Response;
class ConfigurationsPrivateController extends ApiController
{

    public function store(ConfigurationStoreRequest $request,Game $game): JsonResponse
    {

        $configuration = app(ConfigurationStoreAction::class)->run($request);

        $preparedStructureData = $this->transform($configuration, ConfigurationTransformer::class);

        return response()->json($preparedStructureData);
    }


    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     * @throws InvalidDataProvidedForRuleException
     */
    public function update(ConfigurationUpdateRequest $request,Game $game ,Configuration $configuration): JsonResponse
    {

        $configuration = app(ConfigurationUpdateAction::class)->run($request,$configuration);

        $preparedStructureData = $this->transform($configuration, ConfigurationTransformer::class);


        return response()->json($preparedStructureData);
    }


    public function delete(ConfigurationDeleteRequest $request,Game $game ,Configuration $configuration):Response
    {

        app(ConfigurationDeleteAction::class)->run($configuration);

        return response()->noContent();
    }


    public function index(ConfigurationIndexRequest $request, Game $game): JsonResponse
    {
        $configuration = app(ConfigurationIndexAction::class)->run($request);

        $preparedStructureData = $this->transform($configuration, ConfigurationTransformer::class);

        return response()->json($preparedStructureData);
    }



    public function show(ConfigurationShowRequest $request, Game $game, Configuration $configuration): JsonResponse
    {
        $configuration = app(ConfigurationShowAction::class)->run($configuration);

        $preparedStructureData = $this->transform($configuration, ConfigurationTransformer::class);

        return response()->json($preparedStructureData);
    }
}
