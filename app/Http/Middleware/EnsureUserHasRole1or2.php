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
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        
        // Verifica si el usuario tiene role_id igual a 1 o 2
        if ($user && in_array($user->role_id, [1, 2])) {
            return $next($request);
        }

        $url = $request->url();
        return redirect('/')->with('error', "Access denied to {$url}");
    }}
