<?php

namespace App\Ship\Middlewares\Http;

use App\Ship\Exceptions\AuthenticationException;
use Closure;
use Illuminate\Http\Request;
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
        $processedToken =  $request->headers->get('X-PlayerToken');

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
