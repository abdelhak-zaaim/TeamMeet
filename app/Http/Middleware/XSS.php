<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use Symfony\Component\HttpFoundation\Response;

class XSS
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();
        array_walk_recursive($input, function (&$input) {
            $input = (is_null($input)) ? null : Purifier::clean(html_entity_decode($input));
        });
        $request->merge($input);

        return $next($request);
    }
}
