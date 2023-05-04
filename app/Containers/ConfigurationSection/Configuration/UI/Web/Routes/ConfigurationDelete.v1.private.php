<?php

/**
 * @apiGroup           Configuration
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

use App\Containers\ConfigurationSection\Configuration\UI\Web\Controllers\ConfigurationsWebController;
use Illuminate\Support\Facades\Route;

Route::delete('/configurations/{configuration}', [ConfigurationsWebController::class, 'delete'])
    ->middleware(['auth:sanctum'])
    ->name('api.private.games.configurations.delete');
