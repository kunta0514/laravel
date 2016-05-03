<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class AfterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $queries = DB::getQueryLog();
        return $next($request);
    }
}
