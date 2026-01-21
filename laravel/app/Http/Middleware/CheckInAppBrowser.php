<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInAppBrowser
{
    public function handle(Request $request, Closure $next): Response
    {
        // Skip check for public profile pages (/p/*)
        if ($request->is('p/*')) {
            return $next($request);
        }

        $userAgent = $request->header('User-Agent');

        // Regex pour détecter les navigateurs in-app (Facebook, Messenger, Instagram, LinkedIn, etc.)
        $pattern = '/(FBAN|FBAV|Instagram|LinkedIn|Twitter|Snapchat|Line)/i';

        if (preg_match($pattern, $userAgent)) {
            return response()->view('errors.in-app-browser');
        }

        return $next($request);
    }
}
