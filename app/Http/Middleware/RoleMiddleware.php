<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user(); // Haal de geauthenticeerde gebruiker op
    
        if (!$user) {
            return response()->json(['message' => 'Niet geauthenticeerd'], 401);
        }
    
        // Debugging: log de rol van de gebruiker en de toegestane rollen
        #Log::info('Gebruiker rol: ' . $user->role); // Dit logt de rol van de gebruiker
        #Log::info('Toegestane rollen: ' . implode(',', $roles)); // Dit logt de toegestane rollen
    
        // Controleer of de gebruiker de juiste rol heeft
        if (!$user->hasRole($roles)) {
            return response()->json([
                'message' => 'Niet geautoriseerd',
                'user_role' => $user->role,
                'allowed_roles' => $roles
            ], 403);
        }
    
        return $next($request);
    }
    
}
