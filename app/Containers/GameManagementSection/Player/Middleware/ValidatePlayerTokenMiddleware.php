<?php

namespace App\Containers\GameManagementSection\Player\Middleware;

use App\Ship\Exceptions\AuthenticationException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class ValidatePlayerTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $processedToken = Str::replace('Bearer ', '', $request->headers->get('X-PlayerToken'));

        $playerToken = PersonalAccessToken::findToken($processedToken);

        if (
            !$playerToken
            || !$playerToken->getAttribute('tokenable')
        ) {
            throw new AuthenticationException('Player token is not correct');
        }

        return $next($request);
    }
}
