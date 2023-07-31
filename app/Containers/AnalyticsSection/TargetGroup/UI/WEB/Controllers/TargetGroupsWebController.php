<?php

namespace App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AnalyticsSection\TargetGroup\Actions\TargetGroupDeleteAction;
use App\Containers\AnalyticsSection\TargetGroup\Actions\TargetGroupIndexAction;
use App\Containers\AnalyticsSection\TargetGroup\Actions\TargetGroupShowAction;
use App\Containers\AnalyticsSection\TargetGroup\Actions\TargetGroupStoreAction;
use App\Containers\AnalyticsSection\TargetGroup\Actions\TargetGroupUpdateAction;
use App\Containers\AnalyticsSection\TargetGroup\Models\TargetGroup;
use App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Requests\TargetGroupWebDeleteRequest;
use App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Requests\TargetGroupWebIndexRequest;
use App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Requests\TargetGroupWebShowRequest;
use App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Requests\TargetGroupWebStoreRequest;
use App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Requests\TargetGroupWebUpdateRequest;
use App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Transformers\TargetGroupPrivateTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class TargetGroupsWebController extends ApiController
{
    /**
     * @throws ValidatorException
     */
    public function store(TargetGroupWebStoreRequest $request): Response
    {
        app(TargetGroupStoreAction::class)->run($request);

        return response()->noContent(201);
    }

    /**
     * @throws ValidatorException
     */
    public function update(TargetGroupWebUpdateRequest $request, TargetGroup $targetGroup): Response
    {
        app(TargetGroupUpdateAction::class)->run($request, $targetGroup);

        return response()->noContent();
    }

    public function delete(TargetGroupWebDeleteRequest $request, TargetGroup $targetGroup): Response
    {
        app(TargetGroupDeleteAction::class)->run($request, $targetGroup);

        return response()->noContent();
    }

    /**
     * @throws InvalidTransformerException
     */
    public function index(TargetGroupWebIndexRequest $request): JsonResponse
    {
        $targetGroups = app(TargetGroupIndexAction::class)->run($request);

        $preparedTargetGroupsData = $this->transform($targetGroups, TargetGroupPrivateTransformer::class);

        return response()->json($preparedTargetGroupsData);
    }

    /**
     * @throws InvalidTransformerException
     */
    public function show(TargetGroupWebShowRequest $request, TargetGroup $targetGroup): JsonResponse
    {
        $targetGroup = app(TargetGroupShowAction::class)->run($targetGroup);

        $preparedTargetGroupData = $this->transform($targetGroup, TargetGroupPrivateTransformer::class);

        return response()->json($preparedTargetGroupData);
    }
}
