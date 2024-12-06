<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laracasts\Flash\Flash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function create(): \Illuminate\View\View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     *
     * @throws ValidationException
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        if (getSuperAdminSettingKeyValue('enable_google_recaptcha')) {
            $validator = Validator::make($request->all(), [
                'g-recaptcha-response' => ['required'],
            ], [
                'g-recaptcha-response.required' => __('messages.error.google_captcha_required'),
                'g-recaptcha-response.recaptcha' => __('messages.error.captcha_failed'),
            ]);


            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        $request->authenticate();


        $request->session()->regenerate();

        if (empty($request->user()->step) && $request->user()->step != User::STEP_3) {
            return redirect()->intended('customer-onboard');
        }

        app()->setLocale(getUserLang());
        Flash::success(__('messages.success_message.login_successfully'));

        if (!isset($request->remember)) {
            return $this->authenticated($request, Auth::guard()->user())
                ?: redirect()->intended(getDashboardURL())
                ->withCookie(\Cookie::forget('email'))
                ->withCookie(\Cookie::forget('password'))
                ->withCookie(\Cookie::forget('remember'));
        }

        return $this->authenticated($request, Auth::guard()->user())
            ?: redirect()->intended(getDashboardURL())
            ->withCookie(\Cookie::make('email', $request->email, '3600'))
            ->withCookie(\Cookie::make('password', $request->password, '3600'))
            ->withCookie(\Cookie::make('remember', '1', '3600'));
    }

    /**
     * The user has been authenticated.
     *
     * @param  mixed  $user
     * @return void
     */
    public function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
