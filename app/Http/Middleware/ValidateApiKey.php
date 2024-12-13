<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateApiKey
{
    public function handle(Request $request, Closure $next)
    {
        // Haal de sleutel uit de headers
        $apiKey = $request->header('x-api-key');

        // Vergelijk met een verwachte sleutel (bijvoorbeeld uit .env)
        if ($apiKey !== env('API_KEY')) {
            return response()->json(['error' => 'Unauthorized, nuh uh'], 401);
        }

        // Als de sleutel klopt, ga door met het verzoek
        return $next($request);
    }
}
