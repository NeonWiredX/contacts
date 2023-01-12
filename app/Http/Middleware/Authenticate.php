<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    public function handle($request, \Closure $next, ...$guards)
    {
        $token = $request->bearerToken();

        $appPass = env("APP_PASSWORD", "");
        if (empty($appPass) || $token!==$appPass ){
            return response([
                                'message' => 'Unauthenticated'
                            ], 403);
        }

        return $next($request);
    }
}
