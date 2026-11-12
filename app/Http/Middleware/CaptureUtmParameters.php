<?php

namespace App\Http\Middleware;

use App\Services\UtmTrackingService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptureUtmParameters
{
    public function __construct(protected UtmTrackingService $utmService)
    {
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only capture for GET requests on web pages
        if ($request->isMethod('GET') && ! $request->ajax()) {
            $this->utmService->capture($request);
        }

        return $next($request);
    }
}

