<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetCustomCalendarLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next): \Symfony\Component\HttpFoundation\Response
    {
        $eventLink = $request->segment('3');
        $event = getFirstEventAsPerLink($eventLink);

        if (! empty($event) && ! empty($event->user)) {
            App::setLocale($event->user->language);
        } else {
            App::setLocale('en');
        }

        return $next($request);
    }
}
