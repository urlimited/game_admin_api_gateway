<?php

namespace App\Containers\ConfigurationSection\Adjustment\UI\WEB\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\ConfigurationSection\Adjustment\Actions\AdjustmentStoreAction;
use App\Containers\ConfigurationSection\Adjustment\Actions\AdjustmentDeleteAction;
use App\Containers\ConfigurationSection\Adjustment\Actions\AdjustmentIndexAction;
use App\Containers\ConfigurationSection\Adjustment\Actions\AdjustmentShowAction;
use App\Containers\ConfigurationSection\Adjustment\Actions\AdjustmentUpdateAction;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Containers\ConfigurationSection\Adjustment\UI\WEB\Requests\AdjustmentWebDeleteRequest;
use App\Containers\ConfigurationSection\Adjustment\UI\WEB\Requests\AdjustmentWebIndexRequest;
use App\Containers\ConfigurationSection\Adjustment\UI\WEB\Requests\AdjustmentWebShowRequest;
use App\Containers\ConfigurationSection\Adjustment\UI\WEB\Requests\AdjustmentWebStoreRequest;
use App\Containers\ConfigurationSection\Adjustment\UI\WEB\Requests\AdjustmentWebUpdateRequest;
use App\Containers\ConfigurationSection\Adjustment\UI\WEB\Transformers\AdjustmentTransformer;
use App\Ship\Parents\Controllers\ApiController;
use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class AdjustmentsWebController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     * @throws InvalidDataProvidedException
     */
    public function store(AdjustmentWebStoreRequest $request): JsonResponse
    {
        $layout = app(AdjustmentStoreAction::class)->run($request);

        $preparedLayoutData = $this->transform($layout, AdjustmentTransformer::class);

        return response()->json($preparedLayoutData);
    }


    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     * @throws InvalidDataProvidedException
     */
    public function update(AdjustmentWebUpdateRequest $request , Layout $layout): JsonResponse
    {

        $layout = app(AdjustmentUpdateAction::class)->run($request, $layout);

        $preparedLayoutData = $this->transform($layout, AdjustmentTransformer::class);
        return response()->json($preparedLayoutData);
    }


    public function delete(AdjustmentWebDeleteRequest $request , Layout $layout): Response
    {
        app(LayoutDeleteAction::class)->run($layout);

        return response()->noContent();
    }


    public function index(AdjustmentWebIndexRequest $request): JsonResponse
    {
        $layouts = app(LayoutIndexAction::class)->run($request);

        $preparedLayoutData = $this->transform($layouts, AdjustmentTransformer::class);

        return response()->json($preparedLayoutData);
    }


    public function show(AdjustmentWebShowRequest $request, Layout $layout): JsonResponse
    {
        $layout = app(LayoutShowAction::class)->run($layout);

        $preparedLayoutData = $this->transform($layout, AdjustmentTransformer::class);

        return response()->json($preparedLayoutData);
    }
}
