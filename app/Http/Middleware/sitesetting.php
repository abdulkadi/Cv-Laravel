<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Information;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class sitesetting
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $information = Information::first();
        view()->share(['information'=>$information]);
        return $next($request);
    }
}
