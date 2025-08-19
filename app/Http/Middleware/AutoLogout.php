<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutoLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (auth()->check() && (time() - auth()->user()->lastConnexion) > config('session.lifetime') * 60) {
        //     auth()->user()->lastConnexion = time();
        //     auth()->user()->save();
        //     auth()->logout();
        //     return redirect('/')->with('statut', 'Vous avez été déconnecté en raison d\'inactivité.');
        // }
      
    
        return $next($request);
    }
}
