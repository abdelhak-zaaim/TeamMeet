<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCustomerOnBoard
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (empty($request->user()->step) && $request->user()->step != User::STEP_3) {
            return redirect((route('customer.onboard')));
        }

        return $next($request);
    }
}
