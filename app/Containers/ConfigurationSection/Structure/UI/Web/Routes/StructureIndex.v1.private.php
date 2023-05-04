<?php

/**
 * @apiGroup           Structure
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

use App\Containers\ConfigurationSection\Structure\UI\Web\Controllers\StructuresWebController;
use Illuminate\Support\Facades\Route;

Route::get('/structures/', [StructuresWebController::class, 'index'])
    ->middleware(['auth:sanctum'])
    ->name('api.private.games.structures.index');
