<?php

/**
 * @apiGroup           Player
 * @apiName            api.players.update
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

use App\Containers\GameManagementSection\Player\UI\WEB\Controllers\PlayersWebController;
use Illuminate\Support\Facades\Route;

Route::put('/players/{player}', [PlayersWebController::class, 'update'])
    ->middleware(['auth:sanctum'])
    ->name('api.private.games.players.update');
