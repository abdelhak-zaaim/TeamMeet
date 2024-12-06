<?php

use App\Http\Controllers\CashPaymentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\GoogleWebhookController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScheduleEventController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SubscriptionPricingPlanController;
use App\Http\Controllers\SubscriptionTransactionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserPaypalController;
use App\Http\Controllers\UserRazorpayController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Support\Facades\Route;

Route::get('google-auth', [GoogleCalendarController::class, 'oauth'])->name('googleAuth');
Route::get(
    'sync-google-calendar-list',
    [GoogleCalendarController::class, 'syncGoogleCalendarList']
)->name('syncGoogleCalendarList');
Route::get('google/redirect', [GoogleCalendarController::class, 'redirect']);
Route::any('google-webhook', [GoogleWebhookController::class, 'webhook'])->name('google.webhook');

Route::middleware([
    'auth', 'xss', 'role:user', 'verified', 'checkCustomerOnBoard', 'check_subscription',
])->group(function () {
    // User dashboard route
    Route::get(
        '/dashboard',
        [UserDashboardController::class, 'index']
    )->name('dashboard')->withoutMiddleware([
        'check_subscription',
    ]);

    Route::resource('events', EventController::class);
    Route::post('change-event-status/{id}', [EventController::class, 'changeStatus'])->name('change.event.status');

    // Event Schedule Routes
    Route::post('add-schedule', [EventController::class, 'addSchedule'])->name('add.schedule');
    Route::get('/get-slot-by-gap', [EventController::class, 'getSlotByGap'])->name('get.slot.by.gap');
    Route::post('add-event-schedule', [EventController::class, 'addEventSchedule'])->name('add.event.schedule');

    // Schedule Route
    Route::resource('schedules', ScheduleController::class);
    Route::post(
        'add-schedule-time-slot',
        [ScheduleController::class, 'addScheduleTimeSlot']
    )->name('add.schedule.time.slot');

    // Get Time By Schedule Route
    Route::get('/get-time-by-schedule', [EventController::class, 'getTimeBySchedule'])->name('get.time.by.schedule');

    // Scheduled event routes
    Route::resource('scheduled-events', ScheduleEventController::class);

    Route::post(
        'cancel-scheduled-event/{id}',
        [ScheduleEventController::class, 'cancelScheduledEvent']
    )->name('cancel.scheduled.event');

    // Transaction Routes
    Route::get('transactions', [TransactionController::class, 'index'])->name('user.transactions.index');
    Route::get('transactions/{transaction}', [TransactionController::class, 'show'])->name('user.transactions.show');

    // User Subscription Transactions Routes
    Route::get(
        'subscription-transactions',
        [SubscriptionTransactionController::class, 'index']
    )->name('user.subscription.transactions.index');
    Route::get(
        'subscription-transactions/{userTransaction}',
        [SubscriptionTransactionController::class, 'show']
    )->name('user.subscription.transactions.show');

    // Remove hold status user route
    Route::get(
        'remove-hold-status-user/{id}',
        [ScheduleEventController::class, 'removeHoldStatusUser']
    )->name('remove.hold.status.user');

    // google calendar routes
    Route::get(
        'connect-google-calendar',
        [GoogleCalendarController::class, 'googleCalendar']
    )->name('google.calendar.index');
    Route::get(
        'disconnect-google-calendar',
        [GoogleCalendarController::class, 'disconnectGoogleCalendar']
    )->name('disconnectCalendar.destroy');
    Route::post('event-google-calendar', [
        GoogleCalendarController::class, 'eventGoogleCalendarStore',
    ])->name('event.google.calendar.store');

    // Setting routes
    Route::get('/settings', [UserSettingController::class, 'index'])->name('user.settings');
    Route::post('/settings', [UserSettingController::class, 'store'])->name('user.setting.create.update');
    Route::post(
        '/settings/create-update',
        [UserSettingController::class, 'userCredentialUpdate']
    )->name('user.setting.credential.update');
});

Route::middleware(['auth', 'xss', 'role:user', 'verified', 'checkCustomerOnBoard'])->group(function () {
    //Subscription Pricing Plans
    Route::get(
        'subscription-plans',
        [
            SubscriptionPricingPlanController::class, 'index',
        ]
    )->name('subscription.pricing.plans.index');

    // routes for payment types.
    Route::get(
        'choose-payment-type/{planId}/{context?}/{fromScreen?}',
        [SubscriptionPricingPlanController::class, 'choosePaymentType']
    )->name('choose.payment.type');

    // stripe subscription transaction for user
    Route::post(
        'purchase-subscription',
        [SubscriptionController::class, 'purchaseSubscription']
    )->name('purchase-subscription');
    Route::get(
        'user-payment-success',
        [SubscriptionController::class, 'userPaymentSuccess']
    )->name('user.payment.success');
    Route::get(
        'user-failed-payment',
        [SubscriptionController::class, 'userHandleFailedPayment']
    )->name('user.failed.payment');

    // Paypal subscription transaction for user
    Route::get('user-paypal-onboard', [UserPaypalController::class, 'onBoard'])->name('user.paypal.init');
    Route::get('user-paypal-payment-success', [UserPaypalController::class, 'success'])->name('user.paypal.success');
    Route::get('user-paypal-payment-failed', [UserPaypalController::class, 'failed'])->name('user.paypal.failed');

    //Paystack Subsciption Transaction for user
    Route::get('subscription-paystack-success', [PaystackController::class, 'subscriptionPaystackSuccess'])->name('subscription.paystack.success');

    // RazorPay Subsciption Transaction for User
    Route::post('razorpay-onboard',[RazorpayController::class, 'onBoard'])->name('admin.razorpay.init');
    Route::post('razorpay-success',[RazorpayController::class, 'paymentSuccess'])->name('admin.razorpay.success');
    Route::post('razorpay-failed',[RazorpayController::class, 'paymentFailed'])->name('admin.razorpay.failed');

    // cash payment route
    Route::post('cash-payments', [CashPaymentController::class, 'cashPay'])->name('cash.pay');
    Route::post('subscribe-plan-without-price', [CashPaymentController::class, 'subscribePlan'])->name('subscribe.plan.without.price');
});

Route::get('feature-availability', [HomeController::class, 'featureAvailability'])->name('feature.available');
Route::middleware(['xss', 'setLanguage'])->group(function () {
    Route::get('{domain_url}/{user_id}', [EventController::class, 'Allevent'])->name('allevent');
});

Route::middleware(['xss', 'check_subscription', 'setCustomCalendarLang'])->group(function () {
    Route::get('s/{domain_url}/{event_link}', [EventController::class, 'slotsCalendar'])->name('slots');

    Route::get(
        's/{domain_url}/{event_link}/{slot_date}',
        [EventController::class, 'slotDetail']
    )->name('slots.detail');

    Route::post('scheduled-events', [ScheduleEventController::class, 'store'])->name('scheduled-events.store');

    // Confirm scheduled event route
    Route::get(
        'sc/{domain_url}/{event_link}/{uuid}',
        [ScheduleEventController::class, 'confirmEventSchedule']
    )->name('confirm.event.schedule');

    // Cancel page route
    Route::get(
        'sc/{domain_url}/{event_link}/{uuid}/cancel',
        [ScheduleEventController::class, 'cancelPage']
    )->name('sc.cancel');

    // Cancel scheduled event route
    Route::post(
        'sc/{domain_url}/{event_link}/{uuid}',
        [ScheduleEventController::class, 'cancelEventSchedule']
    )->name('cancel.event.schedule');

    Route::get(
        'sc/{domain_url}/{event_link}/{uuid}/verify-otp',
        [ScheduleEventController::class, 'verifyOTPPage']
    )->name('verify.otp.page');

    Route::post(
        'sc/{domain_url}/{event_link}/{uuid}/verify-otp',
        [ScheduleEventController::class, 'verifyOTP']
    )->name('verify.otp');

    Route::post('check-given-otp', [ScheduleEventController::class, 'checkGivenOTP'])->name('check.given.otp');

    Route::get('add-calender/{id}', [ScheduleEventController::class, 'addCalendar'])->name('add.calendar');

    // Stripe route
    Route::get(
        '/payment-success',
        [ScheduleEventController::class, 'paymentSuccess']
    )->name('schedule-event-payment-success');
    Route::get(
        '/payment-failed',
        [ScheduleEventController::class, 'handleFailedPayment']
    )->name('schedule-event-failed-payment');

    // Paypal route
    Route::get('paypal-onboard', [PaypalController::class, 'onBoard'])->name('paypal.init');
    Route::get('paypal-payment-success', [PaypalController::class, 'success'])->name('paypal.success');
    Route::get('paypal-payment-failed', [PaypalController::class, 'failed'])->name('paypal.failed');

    // paypal routes
    Route::get('/paypal-payment', function () {
        return view('payments.paypal.index');
    })->name('paypal.index');

    // PayStack routes
    Route::get('paystack-onboard', [PaystackController::class, 'redirectToGateway'])->name('paystack.init');
    Route::get('paystack-payment-success', [PaystackController::class, 'payStackPaymentSuccess'])->name('paystack.success');

    // RazorPay Route For Event Schedule
    Route::post('event-schedule-razorpay-onboard',[UserRazorpayController::class, 'razorpayonBoard'])->name('user.event.razorpay.init');
    Route::post('event-schedule-razorpay-success',[UserRazorpayController::class, 'eventScheduleRazorpaySuceess'])->name('user.event.razorpay.success');
    Route::post('event-schedule-razorpay-failed',[UserRazorpayController::class, 'eventScheduleRazorpayFailed'])->name('user.event.razorpay.failed');
  
});
