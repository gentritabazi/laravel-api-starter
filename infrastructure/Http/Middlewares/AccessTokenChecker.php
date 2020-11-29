<?php

namespace Infrastructure\Http\Middlewares;

use Closure;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AccessTokenChecker
{
    private $authenticate;

    public function __construct(
        Authenticate $authenticate
    ) {
        $this->authenticate = $authenticate;
    }

    public function handle($request, Closure $next, $scopesString = null)
    {
        try {
            return $this->authenticate->handle($request, $next, 'api');
        } catch (AuthenticationException $e) {
            throw new UnauthorizedHttpException('Challenge', 'Login to continue.');
        }
 
        return $next($request);
    }
}
