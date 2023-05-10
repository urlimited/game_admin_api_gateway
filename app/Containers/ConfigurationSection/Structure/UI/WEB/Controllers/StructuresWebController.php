<?php

namespace App\Containers\ConfigurationSection\Structure\UI\WEB\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\ConfigurationSection\Structure\Actions\StructureDeleteAction;
use App\Containers\ConfigurationSection\Structure\Actions\StructureIndexAction;
use App\Containers\ConfigurationSection\Structure\Actions\StructureShowAction;
use App\Containers\ConfigurationSection\Structure\Actions\StructureStoreAction;
use App\Containers\ConfigurationSection\Structure\Actions\StructureUpdateAction;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\Structure\UI\WEB\Requests\StructureWebDeleteRequest;
use App\Containers\ConfigurationSection\Structure\UI\WEB\Requests\StructureWebIndexRequest;
use App\Containers\ConfigurationSection\Structure\UI\WEB\Requests\StructureWebShowRequest;
use App\Containers\ConfigurationSection\Structure\UI\WEB\Requests\StructureWebStoreRequest;
use App\Containers\ConfigurationSection\Structure\UI\WEB\Requests\StructureWebUpdateRequest;
use App\Containers\ConfigurationSection\Structure\UI\WEB\Transformers\StructureTransformer;
use App\Ship\Parents\Controllers\ApiController;
use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class StructuresWebController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     * @throws InvalidDataProvidedException
     */
    public function store(StructureWebStoreRequest $request): JsonResponse
    {
        $structure = app(StructureStoreAction::class)->run($request);

        $preparedStructureData = $this->transform($structure, StructureTransformer::class);

        return response()->json($preparedStructureData);
    }


    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     * @throws InvalidDataProvidedException
     */
    public function update(StructureWebUpdateRequest $request , Structure $structure): JsonResponse
    {

        $structure = app(StructureUpdateAction::class)->run($request, $structure);

        $preparedStructureData = $this->transform($structure, StructureTransformer::class);
        return response()->json($preparedStructureData);
    }


    public function delete(StructureWebDeleteRequest $request , Structure $structure): Response
    {
        app(StructureDeleteAction::class)->run($structure);

        return response()->noContent();
    }


    public function index(StructureWebIndexRequest $request): JsonResponse
    {
        $structures = app(StructureIndexAction::class)->run($request);

        $preparedStructureData = $this->transform($structures, StructureTransformer::class);

        return response()->json($preparedStructureData);
    }


    public function show(StructureWebShowRequest $request, Structure $structure): JsonResponse
    {
        $structure = app(StructureShowAction::class)->run($structure);

        $preparedStructureData = $this->transform($structure, StructureTransformer::class);

        return response()->json($preparedStructureData);
    }
}
