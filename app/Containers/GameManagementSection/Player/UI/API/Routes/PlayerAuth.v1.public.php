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

use App\Containers\GameManagementSection\Game\Middleware\ValidateGameTokenMiddleware;
use App\Containers\GameManagementSection\Player\UI\API\Controllers\PlayersPublicController;
use Illuminate\Support\Facades\Route;

Route::post('/players/auth', [PlayersPublicController::class, 'auth'])
    ->middleware([ValidateGameTokenMiddleware::class])
    ->name('api.public.players.auth');
