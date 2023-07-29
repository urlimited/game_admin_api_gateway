<?php

/**
 * @apiGroup           Layout
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

use App\Containers\AnalyticsSection\StatEvent\UI\WEB\Controllers\StatEventsWebController;
use Illuminate\Support\Facades\Route;

Route::put('/stat-events/{statEvent:uuid}', [StatEventsWebController::class, 'update'])
    ->middleware(['auth:sanctum'])
    ->name('api.private.stat-events.update');
