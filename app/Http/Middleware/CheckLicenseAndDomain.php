<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLicenseAndDomain
{
    public function handle(Request $request, Closure $next): Response
    {
        // $licenseKey = env('APP_LICENSE_KEY');
        // $allowedDomain = env('APP_URL');
        // $currentDomain = $request->server('HTTP_HOST');

        // if ($currentDomain !== $allowedDomain) {
        //     abort(403, 'Unauthorized domain');
        // }
        return $next($request);
    }
}
