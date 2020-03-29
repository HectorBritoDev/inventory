<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Closure;

class OnlyJsonRequests
{
    use ApiResponser;
    public function handle($request, Closure $next)
    {
        if ($request->expectsJson()) {
            return $next($request);
        }
        return $this->errorResponse('api only available for json request', 422);
    }
}
