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

use App\Containers\ConfigurationSection\Setting\UI\API\Controllers\SettingsApiController;
use App\Ship\Middlewares\Http\ValidateGameTokenMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/settings/{setting:uuid}', [SettingsApiController::class, 'show'])
    ->middleware([ValidateGameTokenMiddleware::class])
    ->name('api.public.games.settings.show');
