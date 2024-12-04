<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Haal de api key uit de header van het verzoek
        $apiKey = $request->header('x-api-key');

        // Vergelijk met de waarde die in de .env staat
        if ($apiKey !== env('API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
