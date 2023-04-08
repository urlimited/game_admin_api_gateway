<?php

namespace App\Containers\ConfigurationSection\Structure\UI\API\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Actions\StructureDeleteAction;
use App\Containers\ConfigurationSection\Structure\Actions\StructureIndexAction;
use App\Containers\ConfigurationSection\Structure\Actions\StructureStoreAction;
use App\Containers\ConfigurationSection\Structure\Actions\StructureUpdateAction;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Exceptions\InvalidDataProvidedForRuleException;
use App\Containers\ConfigurationSection\Structure\UI\API\Requests\StructureDeleteRequest;
use App\Containers\ConfigurationSection\Structure\UI\API\Requests\StructureIndexRequest;
use App\Containers\ConfigurationSection\Structure\UI\API\Requests\StructureShowRequest;
use App\Containers\ConfigurationSection\Structure\UI\API\Requests\StructureStoreRequest;
use App\Containers\ConfigurationSection\Structure\UI\API\Requests\StructureUpdateRequest;
use App\Containers\ConfigurationSection\Structure\UI\API\Transformers\StructureTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class StructuresController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     * @throws InvalidDataProvidedForRuleException
     * @throws ValidatorException
     */
    public function store(StructureStoreRequest $request): JsonResponse
    {
        $structure = app(StructureStoreAction::class)->run($request);

        $preparedStructureData = $this->transform($structure, StructureTransformer::class);

        return response()->json($preparedStructureData);
    }


    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     * @throws InvalidDataProvidedForRuleException
     */
    public function update(StructureUpdateRequest $request, Structure $structure): JsonResponse
    {
        $structure = app(StructureUpdateAction::class)->run($request, $structure);

        $preparedStructureData = $this->transform($structure, StructureTransformer::class);

        return response()->json($preparedStructureData);
    }


    public function delete(StructureDeleteRequest $request, Structure $structure): Response
    {
        app(StructureDeleteAction::class)->run($structure);

        return response()->noContent();
    }


    public function index(StructureIndexRequest $request, Game $game): JsonResponse
    {
        $structures = app(StructureIndexAction::class)->run($game);

        $preparedStructureData = $this->transform($structures, StructureTransformer::class);

        return response()->json($preparedStructureData);
    }


    public function show(StructureShowRequest $request, Structure $structure): JsonResponse
    {
        $preparedStructureData = $this->transform($structure, StructureTransformer::class);

        return response()->json($preparedStructureData);
    }
}
