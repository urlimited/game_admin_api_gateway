<?php

/**
 * @apiGroup           Target group
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

use App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Controllers\TargetGroupsWebController;
use Illuminate\Support\Facades\Route;

Route::get('/target-groups/{targetGroup:uuid}', [TargetGroupsWebController::class, 'show'])
    ->middleware(['auth:sanctum'])
    ->name('api.private.target-groups.show');
