<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NoCacheHeaders
{
    /**
     * Handle an incoming request.
     * 
     * Añade cabeceras HTTP para evitar que el navegador o proxies cacheen la respuesta.
     */
    public function handle(Request $request, Closure $next)
    {
        // Procesa la solicitud y obtiene la respuesta
        $response = $next($request);

        // Añade cabeceras para deshabilitar el cacheo en el navegador y proxies
        return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT'); // Fecha pasada para invalidar cache
    }
}
