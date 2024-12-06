<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CashPaymentController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\Front\AboutUsController;
use App\Http\Controllers\Front\BrandController;
use App\Http\Controllers\Front\FaqController;
use App\Http\Controllers\Front\FrontCMSController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\FrontTestimonialController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\MainReasonController;
use App\Http\Controllers\Front\ServiceController;
use App\Http\Controllers\Front\SubscribeController;
use App\Http\Controllers\PersonalExperienceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubscriptionPlansController;
use App\Http\Controllers\SubscriptionTransactionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Fronted routes
Route::get('sign-up', [FrontController::class, 'signUp'])->name('sign.up')->middleware('setLanguage');
Route::post('sign-up', [FrontController::class, 'signUpStore'])->name('sign.up.store')->middleware('setLanguage');

Route::get('/login', function () {
    return (! Auth::check()) ? \redirect(route('login')) : Redirect::to(getDashboardURL());
});

Route::middleware(['xss', 'setLanguage'])->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('frontHome');
    Route::get('pricing', [HomeController::class, 'pricing'])->name('pricing');
    Route::get('about-us', [HomeController::class, 'aboutUs'])->name('about-us');
    Route::get('contact-us', [HomeController::class, 'contactUs'])->name('contact-us');
    Route::get('faqs', [HomeController::class, 'faq'])->name('faq');
    Route::post('enquiries', [EnquiryController::class, 'store'])->name('enquiries.store');
    Route::get('terms-conditions', [HomeController::class, 'termCondition'])->name('terms.conditions');
    Route::get('privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy.policy');
    Route::post('subscribe', [SubscribeController::class, 'store'])->name('subscribe.store');
    Route::get('email-sign-up', [HomeController::class, 'emailSignUp'])->name('email.sign.up');
    Route::post('/change-language', [HomeController::class, 'changeLanguage'])->name('front.change.language');
});

Route::middleware(['auth', 'xss', 'verified'])->group(function () {
    // Front Customer On Board Routes
    Route::get('customer-onboard', [FrontController::class, 'customerOnBoard'])->name('customer.onboard');
    Route::post('customer-onboard', [FrontController::class, 'store'])->name('customer.onboard.store');

    // Update profile
    Route::get('/profile/edit', [UserProfileController::class, 'editProfile'])->name('profile.setting');
    Route::put('/profile/update', [UserProfileController::class, 'updateProfile'])->name('update.profile.setting');
    Route::put('/change-user-password', [UserProfileController::class, 'changePassword'])->name('user.changePassword');
    Route::put('update-language', [UserController::class, 'updateLanguage'])->name('update-language');

    //impersonate leave
    Route::get('/impersonate-leave', [UserController::class, 'impersonateLeave'])->name('impersonate.leave');
});

Route::prefix('admin')->middleware(['auth', 'role:admin', 'verified', 'checkCustomerOnBoard'])->group(function (
) {

    //admin dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Users Routes
    Route::resource('users', UserController::class);

    // Admin Routes
    Route::resource('admins', AdminController::class);

    // Personal Experiences Routes
    Route::resource('personal-experiences', PersonalExperienceController::class);

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/setting-credential',
        [SettingController::class, 'settingCredential'])->name('setting.credential.update');

    Route::resource('front-testimonials', FrontTestimonialController::class);

    Route::get('front-cms', [FrontCMSController::class, 'index'])->name('front.cms.index');
    Route::post('front-cms',
        [FrontCMSController::class, 'update'])->name('front.cms.update')->withoutMiddleware('xss');

    // Brand Routes
    Route::resource('brands', BrandController::class);
    Route::post('brands/{brand}/update', [BrandController::class, 'update']);

    Route::get('front-service', [ServiceController::class, 'index'])->name('front.service.index');
    Route::post('front-service', [ServiceController::class, 'update'])->name('front.service.update');

    Route::get('main-reasons', [MainReasonController::class, 'index'])->name('main.reasons.index');
    Route::post('main-reasons', [MainReasonController::class, 'update'])->name('main.reasons.update');

    Route::get('enquiries', [EnquiryController::class, 'index'])->name('enquiries.index');
    Route::get('enquiries/{enquiry}', [EnquiryController::class, 'show'])->name('enquiries.show');
    Route::delete('enquiries/{enquiry}', [EnquiryController::class, 'destroy'])->name('enquiries.destroy');

    // Faqs Routes
    Route::resource('faqs', FaqController::class);

    Route::get('main-reasons', [MainReasonController::class, 'index'])->name('main.reasons.index');
    Route::post('main-reasons', [MainReasonController::class, 'update'])->name('main.reasons.update');

    Route::get('about-us', [AboutUsController::class, 'index'])->name('about.us.index');
    Route::post('about-us', [AboutUsController::class, 'update'])->name('about.us.update');

    // Subscription Plans
    Route::resource('subscription-plans', SubscriptionPlansController::class)->except(['update']);
    Route::put('subscription-plan/{subscription_plan}',
    [SubscriptionPlansController::class, 'updateSubscriptionPlan'])->name('subscription-plans.update');
    Route::post('subscription-plans/{user}/make-plan-as-default',
        [SubscriptionPlansController::class, 'makePlanDefault'])->name('make.plan.default');

    // Subscribe Routes
    Route::get('subscribers', [SubscribeController::class, 'index'])->name('subscribers.index');
    Route::delete('subscribers/{subscribe}', [SubscribeController::class, 'destroy'])->name('subscribers.destroy');

    // Remove hold status all route
    Route::get('remove-hold-status', [SettingController::class, 'removeHoldStatus'])->name('remove.hold.status');

    // Transaction Routes
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');

    // Subscription Transactions Routes
    Route::get('subscription-transactions',
        [SubscriptionTransactionController::class, 'index'])->name('subscription.transactions.index');
    Route::get('subscription-transactions/{userTransaction}',
        [SubscriptionTransactionController::class, 'show'])->name('subscription.transactions.show');

    // Currency routes
    Route::resource('currencies', CurrencyController::class);

    //impersonate
    Route::get('/impersonate/{user}', [UserController::class, 'impersonate'])->name('impersonate');

    // manual subscription payment route
    Route::get('cash-payments', [CashPaymentController::class, 'index'])->name('cash.payments.index');
    Route::get('download-attachment/{mediaId}', [CashPaymentController::class, 'downloadAttachment'])->name('download.attachment');
});

require __DIR__.'/auth.php';
require __DIR__.'/user.php';
require __DIR__.'/upgrade.php';
