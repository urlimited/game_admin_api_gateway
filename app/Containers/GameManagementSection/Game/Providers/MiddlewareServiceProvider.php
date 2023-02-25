<?php

namespace App\Containers\GameManagementSection\Game\Providers;

use App\Containers\GameManagementSection\Game\Middleware\ValidateGameTokenMiddleware;
use App\Ship\Parents\Providers\MiddlewareProvider;
use Illuminate\Support\Collection;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * @property int $id
 * @property string $name
 * @property string $genre
 * @property Collection<PersonalAccessToken> $tokens
 */
class MiddlewareServiceProvider extends MiddlewareProvider
{
    protected array $middlewares = [
        'isGameTokenValid' => ValidateGameTokenMiddleware::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
