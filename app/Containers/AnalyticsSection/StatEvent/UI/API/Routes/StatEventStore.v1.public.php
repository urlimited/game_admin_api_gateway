<?php

/**
 * @apiGroup           Stat event data
 * @apiName            api.players.create
 * @api                {post} /v1/admins Create Admin type Users
 * @apiDescription     Create non client users for the Dashboard.
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  email
 * @apiParam           {String}  password
 * @apiParam           {String}  name
 *
 * @apiUse             UserSuccessSingleResponse
 */

use App\Containers\AnalyticsSection\StatEvent\UI\API\Controllers\StatEventDataAPIController;
use App\Ship\Middlewares\Http\ValidateGameTokenMiddleware;
use App\Ship\Middlewares\Http\ValidatePlayerTokenMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/stat-event-data/', [StatEventDataAPIController::class, 'store'])
    ->middleware([ValidateGameTokenMiddleware::class, ValidatePlayerTokenMiddleware::class])
    ->name('api.public.stat-event-data.store');
