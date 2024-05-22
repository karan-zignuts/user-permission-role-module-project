<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next, $moduleCode, $action)
    {
        if (Auth::check()) {
            if ($request->user()->hasUserAccess($moduleCode, $action)) {
                return $next($request);
            }
        }
        return abort(403, 'Unauthorized');
    }
}
