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

use App\Containers\ConfigurationSection\Structure\UI\API\Controllers\StructuresController;
use Illuminate\Support\Facades\Route;

Route::put('/games/{game}/structures/{structure}', [StructuresController::class, 'update'])
    ->middleware(['auth:sanctum'])
    ->name('api.private.games.structures.update');