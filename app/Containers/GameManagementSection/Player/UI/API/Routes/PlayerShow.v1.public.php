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
use App\Containers\GameManagementSection\Player\Middleware\ValidatePlayerTokenMiddleware;
use App\Containers\GameManagementSection\Player\UI\API\Controllers\PlayersApiController;
use Illuminate\Support\Facades\Route;

Route::get('/players/profile', [PlayersApiController::class, 'show'])
    ->middleware([ValidateGameTokenMiddleware::class, ValidatePlayerTokenMiddleware::class])
    ->name('api.public.players.show');
