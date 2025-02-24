<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Verificar si el usuario está autenticado y tiene el rol de "admin"
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request); // Permitir el acceso
        }

        // Si no es admin, redirigir o denegar el acceso
        return redirect('/')->with('error', 'No tienes permisos para realizar esta acción.');
    }
}
