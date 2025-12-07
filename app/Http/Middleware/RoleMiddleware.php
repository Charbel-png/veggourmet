<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // tipo = columna 'tipo' en la tabla users: admin, operador, cliente
        if (! in_array($user->tipo, $roles)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
