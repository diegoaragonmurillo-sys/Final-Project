<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
{
    // Si NO está logueado → enviar al login
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    // Si está logueado pero NO es admin → bloquear
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Acceso denegado: solo administradores.');
    }

    return $next($request);
}

}
