<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
//use Symfony\Component\HttpFoundation\Response;

class CheckPatient
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'patient') {
            return $next($request);
        }
        return response()->json(['message' => 'Acceso denegado: Solo para Pacientes.'], 403);
    }
}
