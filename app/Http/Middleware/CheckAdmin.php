<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    // {
    //     if (!auth()->check()) {
    //         return response()->json(['message' => 'Unauthenticated'], 401);
    //     }

    //     if (auth()->user()->role !== 'admin') {
    //         return response()->json(['message' => 'Admin access required'], 403);
    //     }

    //     return $next($request);
    // }
    {
        if (auth()->user()->role !== 'admin') {
        return response()->json(['message' => 'Forbidden'], 403);
        }
        return $next($request);
    }
}