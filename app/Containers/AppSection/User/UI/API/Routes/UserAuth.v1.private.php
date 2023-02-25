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

use App\Containers\AppSection\User\UI\API\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::post('/auth', [AuthenticationController::class, 'auth'])
    ->name('api.private.users.auth');
