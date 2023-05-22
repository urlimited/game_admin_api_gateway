<?php

/**
 * @apiGroup           Setting
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

use App\Containers\ConfigurationSection\Adjustment\UI\WEB\Controllers\AdjustmentsWebController;
use Illuminate\Support\Facades\Route;

Route::get('/adjustments/', [AdjustmentsWebController::class, 'index'])
    ->middleware(['auth:sanctum'])
    ->name('api.private.adjustments.index');
