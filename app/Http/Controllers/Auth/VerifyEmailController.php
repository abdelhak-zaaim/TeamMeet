<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            if (empty($request->user()->step) && $request->user()->step != User::STEP_3) {
                return redirect()->intended('customer-onboard');
            }

            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        if (empty($request->user()->step) && $request->user()->step != User::STEP_3) {
            return redirect()->intended('customer-onboard');
        }

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
}
