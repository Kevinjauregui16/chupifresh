<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequest
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Loguear la solicitud entrante (en formato JSON)
        Log::info('Request Data: ' . json_encode($request->all()));

        // Capturar la respuesta
        $response = $next($request);

        // Loguear la respuesta en formato JSON
        // Usar getContent() para obtener el contenido de la respuesta
        if ($response->headers->get('Content-Type') === 'application/json') {
            Log::info('Response Data: ' . $response->getContent());
        } else {
            Log::info('Response Data: No es JSON');
        }

        return $response;
    }
}
