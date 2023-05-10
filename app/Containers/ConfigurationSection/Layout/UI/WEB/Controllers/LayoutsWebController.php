<?php

namespace App\Containers\ConfigurationSection\Layout\UI\WEB\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\ConfigurationSection\Layout\Actions\LayoutDeleteAction;
use App\Containers\ConfigurationSection\Layout\Actions\LayoutIndexAction;
use App\Containers\ConfigurationSection\Layout\Actions\LayoutShowAction;
use App\Containers\ConfigurationSection\Layout\Actions\LayoutStoreAction;
use App\Containers\ConfigurationSection\Layout\Actions\LayoutUpdateAction;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Containers\ConfigurationSection\Layout\UI\WEB\Requests\LayoutWebDeleteRequest;
use App\Containers\ConfigurationSection\Layout\UI\WEB\Requests\LayoutWebIndexRequest;
use App\Containers\ConfigurationSection\Layout\UI\WEB\Requests\LayoutWebShowRequest;
use App\Containers\ConfigurationSection\Layout\UI\WEB\Requests\LayoutWebStoreRequest;
use App\Containers\ConfigurationSection\Layout\UI\WEB\Requests\LayoutWebUpdateRequest;
use App\Containers\ConfigurationSection\Layout\UI\WEB\Transformers\LayoutTransformer;
use App\Ship\Parents\Controllers\ApiController;
use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class LayoutsWebController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     * @throws InvalidDataProvidedException
     */
    public function store(LayoutWebStoreRequest $request): JsonResponse
    {
        $layout = app(LayoutStoreAction::class)->run($request);

        $preparedLayoutData = $this->transform($layout, LayoutTransformer::class);

        return response()->json($preparedLayoutData);
    }


    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     * @throws InvalidDataProvidedException
     */
    public function update(LayoutWebUpdateRequest $request , Layout $layout): JsonResponse
    {

        $layout = app(LayoutUpdateAction::class)->run($request, $layout);

        $preparedLayoutData = $this->transform($layout, LayoutTransformer::class);
        return response()->json($preparedLayoutData);
    }


    public function delete(LayoutWebDeleteRequest $request , Layout $layout): Response
    {
        app(LayoutDeleteAction::class)->run($layout);

        return response()->noContent();
    }


    public function index(LayoutWebIndexRequest $request): JsonResponse
    {
        $layouts = app(LayoutIndexAction::class)->run($request);

        $preparedLayoutData = $this->transform($layouts, LayoutTransformer::class);

        return response()->json($preparedLayoutData);
    }


    public function show(LayoutWebShowRequest $request, Layout $layout): JsonResponse
    {
        $layout = app(LayoutShowAction::class)->run($layout);

        $preparedLayoutData = $this->transform($layout, LayoutTransformer::class);

        return response()->json($preparedLayoutData);
    }
}
