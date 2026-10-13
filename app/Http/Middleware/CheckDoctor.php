<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDoctor
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'doctor') {
            return $next($request);
        }
        return response()->json(['message' => 'Acceso denegado: Solo para Médicos.'], 403);
    }
}