<?php

/**
 * @apiGroup           Player
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

use App\Containers\GameManagementSection\Player\UI\WEB\Controllers\PlayersWebController;
use Illuminate\Support\Facades\Route;

Route::get('/players/{player_id}', [PlayersWebController::class, 'show'])
    ->middleware(['auth:sanctum'])
    ->name('api.private.games.players.show');
