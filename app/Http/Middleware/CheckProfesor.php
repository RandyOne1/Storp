<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProfesor
{
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->privilegios === 'profesor') {
            return $next($request);
        }

        abort(403, 'Acceso denegado. Debes tener privilegios de profesor para acceder a esta página.');
    }
}
