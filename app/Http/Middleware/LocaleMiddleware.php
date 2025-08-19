<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->get('lang', 'en'); // Par exemple, obtenir la langue à partir d'un paramètre d'URL (lang=en/fr)

        // Définir dynamiquement la langue pour la requête
        App::setLocale($lang);
        
        return $next($request);
    }
}
