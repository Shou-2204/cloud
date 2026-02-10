<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceAppUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $appUrl = config('app.url');
        
        // Parse the host from APP_URL
        $parsedUrl = parse_url($appUrl);
        $expectedHost = $parsedUrl['host'] ?? null;
        $scheme = $parsedUrl['scheme'] ?? 'https';

        if (! $expectedHost) {
            return $next($request);
        }

        // Check if current host matches expected host
        if ($request->getHost() !== $expectedHost) {
            // Reconstruct the URL with the correct scheme and host
            $targetUrl = $scheme . '://' . $expectedHost . $request->getRequestUri();
            
            return redirect()->to($targetUrl, 301);
        }

        return $next($request);
    }
}
