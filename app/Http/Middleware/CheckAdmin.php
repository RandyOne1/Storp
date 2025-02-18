<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->privilegios === 'administrador') {
            return $next($request);
        }

        abort(403, 'Acceso denegado. Debes tener privilegios elevados para acceder a esta página.');
    }
}
