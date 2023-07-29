<?php

namespace App\Containers\AnalyticsSection\StatEvent\UI\API\Controllers;

use App\Containers\AnalyticsSection\StatEvent\Actions\StatEventDataStoreAction;
use App\Containers\AnalyticsSection\StatEvent\UI\API\Requests\StatEventDataAPIStoreRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class StatEventDataAPIController extends ApiController
{
    /**
     * @throws ValidatorException
     */
    public function store(StatEventDataAPIStoreRequest $request): Response
    {
        app(StatEventDataStoreAction::class)->run($request);

        return response()->noContent(201);
    }
}
