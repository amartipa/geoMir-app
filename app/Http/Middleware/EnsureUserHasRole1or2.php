<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole1or2
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
    \Log::debug($roles);
    // Check if the user has at least one of the allowed roles (1 or 2)
    if (!in_array($request->user()->role_id, $roles)) {
    $url = $request->url();
    return redirect('dashboard')->with('error', "Access denied to {$url}");
    }
    
    return $next($request);
    }
}
