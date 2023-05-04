<?php

namespace App\Containers\ConfigurationSection\Structure\UI\Web\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\ConfigurationSection\Structure\Actions\StructureDeleteAction;
use App\Containers\ConfigurationSection\Structure\Actions\StructureIndexAction;
use App\Containers\ConfigurationSection\Structure\Actions\StructureShowAction;
use App\Containers\ConfigurationSection\Structure\Actions\StructureStoreAction;
use App\Containers\ConfigurationSection\Structure\Actions\StructureUpdateAction;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\Structure\UI\Web\Requests\StructureWebDeleteRequest;
use App\Containers\ConfigurationSection\Structure\UI\Web\Requests\StructureWebIndexRequest;
use App\Containers\ConfigurationSection\Structure\UI\Web\Requests\StructureWebShowRequest;
use App\Containers\ConfigurationSection\Structure\UI\Web\Requests\StructureWebStoreRequest;
use App\Containers\ConfigurationSection\Structure\UI\Web\Requests\StructureWebUpdateRequest;
use App\Containers\ConfigurationSection\Structure\UI\Web\Transformers\StructureTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class StructuresWebController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
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
