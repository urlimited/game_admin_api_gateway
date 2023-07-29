<?php

namespace App\Containers\AnalyticsSection\StatEvent\UI\WEB\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AnalyticsSection\StatEvent\Actions\StatEventDeleteAction;
use App\Containers\AnalyticsSection\StatEvent\Actions\StatEventIndexAction;
use App\Containers\AnalyticsSection\StatEvent\Actions\StatEventShowAction;
use App\Containers\AnalyticsSection\StatEvent\Actions\StatEventStoreAction;
use App\Containers\AnalyticsSection\StatEvent\Actions\StatEventUpdateAction;
use App\Containers\AnalyticsSection\StatEvent\Models\StatEvent;
use App\Containers\AnalyticsSection\StatEvent\UI\WEB\Requests\StatEventWebDeleteRequest;
use App\Containers\AnalyticsSection\StatEvent\UI\WEB\Requests\StatEventWebIndexRequest;
use App\Containers\AnalyticsSection\StatEvent\UI\WEB\Requests\StatEventWebShowRequest;
use App\Containers\AnalyticsSection\StatEvent\UI\WEB\Requests\StatEventWebStoreRequest;
use App\Containers\AnalyticsSection\StatEvent\UI\WEB\Requests\StatEventWebUpdateRequest;
use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Containers\AnalyticsSection\StatEvent\UI\WEB\Transformers\StatEventPrivateTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class StatEventsWebController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     */
    public function store(StatEventWebStoreRequest $request): JsonResponse
    {
        $statEvent = app(StatEventStoreAction::class)->run($request);

        $preparedStatEventData = $this->transform($statEvent, StatEventPrivateTransformer::class);

        return response()->json($preparedStatEventData);
    }

    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     */
    public function update(StatEventWebUpdateRequest $request, StatEvent $statEvent): JsonResponse
    {
        $statEvent = app(StatEventUpdateAction::class)->run($request, $statEvent);

        $preparedStatEventData = $this->transform($statEvent, StatEventPrivateTransformer::class);

        return response()->json($preparedStatEventData);
    }

    public function delete(StatEventWebDeleteRequest $request, StatEvent $statEvent): Response
    {
        app(StatEventDeleteAction::class)->run($statEvent);

        return response()->noContent();
    }

    /**
     * @throws InvalidTransformerException
     */
    public function index(StatEventWebIndexRequest $request): JsonResponse
    {
        $statEvents = app(StatEventIndexAction::class)->run($request);

        $preparedStatEventData = $this->transform($statEvents, StatEventPrivateTransformer::class);

        return response()->json($preparedStatEventData);
    }

    /**
     * @throws InvalidTransformerException
     */
    public function show(StatEventWebShowRequest $request, StatEvent $statEvent): JsonResponse
    {
        $statEvent = app(StatEventShowAction::class)->run($statEvent);

        $preparedStatEventData = $this->transform($statEvent, StatEventPrivateTransformer::class);

        return response()->json($preparedStatEventData);
    }
}
