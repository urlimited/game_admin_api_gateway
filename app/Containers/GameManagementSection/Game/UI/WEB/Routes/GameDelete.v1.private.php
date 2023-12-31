<?php

/**
 * @apiGroup           Game
 * @apiName            api.games.delete
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

use App\Containers\GameManagementSection\Game\UI\WEB\Controllers\GamesWebController;
use Illuminate\Support\Facades\Route;

Route::delete('/games/{game:uuid}', [GamesWebController::class, 'delete'])
    ->middleware('auth:sanctum')
    ->name('api.games.delete');
