<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Auth::check() && ! \Auth::user()->hasRole('user') || ! \Auth::check()) {
            return $next($request);
        }

        $subscription = getSubscription();

        if (! $subscription) {
            return redirect()->route('subscription.pricing.plans.index');
        }

        if ($subscription->isExpired()) {
            return redirect()->route('subscription.pricing.plans.index');
        }

        return $next($request);
    }
}
