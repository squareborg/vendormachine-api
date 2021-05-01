<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;


class SuspendedUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && ! $request->user()->is_suspended) {
            return $next($request);
        }

        return response(null, Response::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS);
    }
}
