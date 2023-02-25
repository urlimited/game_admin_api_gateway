<?php

/**
 * @apiGroup           Game
 * @apiName            api.games.create
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

use App\Containers\GameManagementSection\Game\UI\API\Controllers\GamesController;
use Illuminate\Support\Facades\Route;

Route::post('/games/{game}/token', [GamesController::class, 'reCreateApiToken'])->name('api.games.reCreateApiToken');
