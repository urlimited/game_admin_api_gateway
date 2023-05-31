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

use App\Containers\ConfigurationSection\Layout\UI\WEB\Controllers\LayoutsWebController;
use Illuminate\Support\Facades\Route;

Route::get('/layouts/{layout:uuid}', [LayoutsWebController::class, 'show'])
    ->middleware(['auth:sanctum'])
    ->name('api.private.games.layouts.show');
