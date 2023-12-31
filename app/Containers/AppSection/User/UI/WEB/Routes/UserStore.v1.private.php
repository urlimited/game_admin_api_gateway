<?php

/**
 * @apiGroup           User
 * @apiName            createAdmin
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

use App\Containers\AppSection\User\UI\WEB\Controllers\UsersWebController;
use Illuminate\Support\Facades\Route;

Route::post('/users', [UsersWebController::class, 'store'])
    ->middleware(['auth:sanctum'])
    ->name('api.private.users.store');
