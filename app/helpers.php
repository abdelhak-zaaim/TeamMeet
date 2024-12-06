<?php

use App\Models\Currency;
use App\Models\Event;
use App\Models\EventSchedule;
use App\Models\FrontCMSSetting;
use App\Models\PlanFeature;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserSchedule;
use App\Models\UserSetting;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

function getLogInUser(): ?Authenticatable
{
    return Auth::user();
}

function getAppName()
{
    static $appName;

    if (empty($appName)) {
        $appName = Setting::where('key', '=', 'application_name')->first()->value;
    }

    return $appName;
}

function isAuth(): bool
{
    return Auth::check() ? true : false;
}

function getLogInUserId(): int
{
    return Auth::user()->id;
}

/**
 * @return mixed|null
 */
function checkLanguageSession()
{
    if (Session::has('languageName')) {
        return Session::get('languageName');
    }

    return 'en';
}

function getUserLang()
{
    return Auth::user()->language;
}

function getCurrentLanguageName(): string
{
    return User::LANGUAGES[checkLanguageSession()];
}

function getDashboardURL(): string
{
    if (empty(getLogInUser()->step) && getLogInUser()->step != User::STEP_3) {
        return 'customer-onboard';
    }

    if (getLogInUser()->hasRole('user')) {
        return 'dashboard';
    }

    return RouteServiceProvider::HOME;
}

function getSchedulesTiming(): array
{
    $period = new CarbonPeriod('00:00', '60 minutes', '24:00'); // for create use 24 hours format later change format
    $times = [];
    foreach ($period as $item) {
        $times[$item->format(getUserSettingTimeFormat(getLogInUserId()))] = $item->format(getUserSettingTimeFormat(getLogInUserId()));
    }

    return $times;
}

/**
 * @return string[]
 */
function getUserLanguages(): array
{
    $language = User::LANGUAGES;
    asort($language);

    return $language;
}

function setEmailLowerCase($email): string
{
    return strtolower($email);
}

function getSlotByGap($startTime, $endTime): array
{
    $period = new CarbonPeriod($startTime, '15 minutes',
        $endTime); // for create use 24 hours format later change format
    $slots = [];
    foreach ($period as $item) {
        $slots[$item->format(getUserSettingTimeFormat(getLogInUserId()))] = $item->format(getUserSettingTimeFormat(getLogInUserId()));
    }

    return $slots;
}

function getConstTimeArr(): array
{
    $period = new CarbonPeriod('12:00 AM', '15 minutes',
        '11:45 PM'); // for create use 24 hours format later change format
    $times = [];
    foreach ($period as $item) {
        $times[$item->format(getUserSettingTimeFormat(getLogInUserId()))] = $item->format(getUserSettingTimeFormat(getLogInUserId()));
    }

    return $times;
}

function getBadgeColors($index): string
{
    $colors = [
        1 => 'success',
        2 => 'info',
        3 => 'danger',
    ];

    return $colors[$index];
}

function getBadgeEventTypeColors($index): string
{
    $colors = [
        1 => 'info',
        2 => 'success',
    ];

    return $colors[$index];
}

/**
 * @return mixed
 */
function defaultUserSchedule()
{
    static $value;

    if (empty($value)) {
        $value = getLogInUser()->schedule()->whereIsDefault(true)->first()->id;
    }

    return $value;
}

function defaultScheduleWeekDays(): array
{
    return UserSchedule::user()->whereScheduleId(defaultUserSchedule())->whereNull('event_id')->pluck('day_of_week')->toArray();
}

function getEventLandingLink(): string
{
    return Request::root().'/s/'.getLogInUser()->domain_url.'/';
}

/**
 * @return Repository|Application|HigherOrderBuilderProxy|mixed|string
 */
function getStripeSecretKey($userID)
{
    $userStripe = UserSetting::whereUserId($userID)
        ->where('key', '=', 'stripe_secret')->first();

    if (! empty($userStripe) && ! empty($userStripe->value)) {
        return $userStripe->value;
    } else {
        return config('services.stripe.secret_key');
    }
}

/**
 * @return Repository|Application|mixed
 */
function getSuperAdminStripeSecretKey()
{
    $adminStripe = Setting::where('key', '=', 'stripe_secret')->first();

    if (! empty($adminStripe) && ! empty($adminStripe->value)) {
        return $adminStripe->value;
    } else {
        return config('services.stripe.secret_key');
    }
}

function getCurrencyIcon(): string
{
    static $currencyIcon;

    if (empty($currencyIcon)) {
        $defaultCurrencyCode = Setting::where('key', 'currency')->first()->value;

        $currencyIcon = Currency::whereCurrencyCode($defaultCurrencyCode)->first()->currency_icon;
    }

    return $currencyIcon;
}

function getCurrencyCode(): string
{
    static $currencyCode;

    if (empty($currencyCode)) {
        $defaultCurrencyCode = Setting::where('key', 'currency')->first()->value;

        $currencyCode = Currency::whereCurrencyCode($defaultCurrencyCode)->first()->currency_code;
    }

    return strtoupper($currencyCode);
}

/**
 * @return mixed
 */
function getSettingData()
{
    static $setting;

    if (empty($setting)) {
        $setting = Setting::toBase()->pluck('value', 'key')->toArray();
    }

    return $setting;
}

/**
 * @return mixed
 */
function getUserSettingData($userID)
{
    static $userSetting;

    if (empty($setting)) {
        $userSetting = UserSetting::whereUserId($userID)->pluck('value', 'key')->toArray();
    }

    return $userSetting;
}

function getSlotConfirmPageUrl($eventSchedule): string
{
    return url('/').'/sc/'.$eventSchedule->event->user->domain_url.'/'.$eventSchedule->event->event_link.'/'.$eventSchedule->uuid;
}

function getFrontCMSSetting(): array
{
    return FrontCMSSetting::toBase()->pluck('value', 'key')->toArray();
}

function getRegisteredUsersCount(): int
{
    return User::role('user')->count();
}

function getTimeZone(): int|string
{

    if (config('app.env') == 'local') {
        $ip = '103.251.59.73';
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    Log::info('IP : '.$ip);

    if (Cache::get($ip)) {
        return Cache::get($ip);
    }

    $ipInfo = file_get_contents('http://ip-api.com/json/'.$ip);
    $ipInfo = json_decode($ipInfo);
    $timeZoneName = $ipInfo->timezone;

    Log::info('Timezone : '.$timeZoneName);

    if (isset($timeZoneName)) {
        foreach (User::TIME_ZONE_ARRAY as $key => $value) {
            if ($timeZoneName == $value) {
                Cache::put($ip, $key);

                return $key;
            }
        }
    }

    return 160;
}

function getEventsCreatedCount(): int
{
    static $value;

    if (empty($value)) {
        $value = Event::whereStatus(true)->count();
    }

    return $value;
}

function getScheduledEventsCount(): int
{
    static $value;

    if (empty($value)) {
        $value = EventSchedule::whereStatus(EventSchedule::BOOKED)->count();
    }

    return $value;
}

function getSubscriptionPlanCurrencyIcon($code): string
{
    $currencyCode = strtoupper($code);
    $currency = Currency::whereCurrencyCode($currencyCode)->first();
    $currencyIcon = $currency->currency_icon ?? '$';

    return $currencyIcon;
}

function getSubscriptionPlanCurrencyCode($key): string
{
    $currencyPath = file_get_contents(resource_path().'/currencies/defaultCurrency.json');
    $currenciesData = json_decode($currencyPath, true)['currencies'];
    $currency = collect($currenciesData)->firstWhere('code',
        strtoupper($key));
        if(empty($currency)){
            $currency['code'] = strtoupper($key);
        }

    return $currency['code'];
}

function zeroDecimalCurrencies(): array
{
    return [
        'BIF', 'CLP', 'DJF', 'GNF', 'JPY', 'KMF', 'KRW', 'MGA', 'PYG', 'RWF', 'UGX', 'VND', 'VUV', 'XAF', 'XOF', 'XPF',
    ];
}

function getCurrencyFullName(): array
{
    $currencyPath = file_get_contents(resource_path().'/currencies/defaultCurrency.json');
    $currenciesData = json_decode($currencyPath, true);
    $currencies = [];

    foreach ($currenciesData['currencies'] as $currency) {
        $convertCode = strtolower($currency['code']);
        $currencies[$convertCode] = $currency['symbol'].' - '.$currency['code'].' '.$currency['name'];
    }

    return $currencies;
}

/**
 * @return Builder|Model|object|null
 */
function getCurrentActiveSubscriptionPlan()
{
    return Subscription::with('subscriptionPlan')->where('status', Subscription::ACTIVE)
        ->where('user_id', getLogInUserId())
        ->first();
}

function getParseDate($date): Carbon
{
    return Carbon::parse($date);
}

/**
 * @return Builder|Model|object|null
 */
function currentActiveSubscription()
{
    static $activeSubscription;

    if (empty($activeSubscription)) {
        $activeSubscription = getSubscription();
    }

    return $activeSubscription;
}

/**
 * @param  Subscription  $currentSubscription
 */
function checkIfPlanIsInTrial($currentSubscription): bool
{
    $now = Carbon::now();
    if (! empty($currentSubscription->trial_ends_at) && $currentSubscription->trial_ends_at > $now) {
        return true;
    }

    return false;
}

function getCurrentPlanDetails(): array
{
    $currentSubscription = currentActiveSubscription();
    $isExpired = $currentSubscription->isExpired();
    $currentPlan = $currentSubscription->subscriptionPlan;

    if ($currentPlan->price != $currentSubscription->plan_amount) {
        $currentPlan->price = $currentSubscription->plan_amount;
    }

    $startsAt = Carbon::now();
    $totalDays = Carbon::parse($currentSubscription->starts_at)->diffInDays($currentSubscription->ends_at);
    $usedDays = Carbon::parse($currentSubscription->starts_at)->diffInDays($startsAt);
    $remainingDays = $totalDays - $usedDays;

    $frequency = $currentSubscription->plan_frequency == SubscriptionPlan::MONTH ? 'Monthly' : 'Yearly';

    $days = $currentSubscription->plan_frequency == SubscriptionPlan::MONTH ? 30 : 365;

    $perDayPrice = round($currentPlan->price / $days, 2);

    if (checkIfPlanIsInTrial($currentSubscription)) {
        $remainingBalance = 0.00;
        $usedBalance = 0.00;
    } else {
        $remainingBalance = $currentPlan->price - ($perDayPrice * $usedDays);
        $usedBalance = $currentPlan->price - $remainingBalance;
    }

    return [
        'name' => $currentPlan->name.' / '.$frequency,
        'trialDays' => $currentPlan->trial_days,
        'startAt' => Carbon::parse($currentSubscription->starts_at)->translatedFormat('jS M, Y'),
        'endsAt' => Carbon::parse($currentSubscription->ends_at)->translatedFormat('jS M, Y'),
        'usedDays' => $usedDays,
        'remainingDays' => $remainingDays,
        'totalDays' => $totalDays,
        'usedBalance' => $usedBalance,
        'remainingBalance' => $remainingBalance,
        'isExpired' => $isExpired,
        'currentPlan' => $currentPlan,
    ];
}

function getProratedPlanData($planIDChosenByUser): array
{
    /** @var SubscriptionPlan $subscriptionPlan */
    $subscriptionPlan = SubscriptionPlan::findOrFail($planIDChosenByUser);
    // $newPlanDays = $subscriptionPlan->frequency == SubscriptionPlan::MONTH ? 30 : 365;
    if($subscriptionPlan->frequency == SubscriptionPlan::MONTH)
    {
        $newPlanDays = 30;
        $frequency = 'Monthly';
    }elseif($subscriptionPlan->frequency == SubscriptionPlan::YEAR){
        $newPlanDays = 365;
        $frequency = 'Yearly';
    }else{
        $newPlanDays = 36500;
        $frequency = 'Unlimited';
    }

    $currentSubscription = currentActiveSubscription();
    // $frequency = $subscriptionPlan->frequency == SubscriptionPlan::MONTH ? 'Monthly' : 'Yearly';

    $startsAt = Carbon::now();

    $carbonParseStartAt = Carbon::parse($currentSubscription->starts_at);
    $usedDays = $carbonParseStartAt->copy()->diffInDays($startsAt);
    $totalExtraDays = 0;
    $totalDays = $newPlanDays;

    $endsAt = Carbon::now()->addDays($newPlanDays);

    $startsAt = $startsAt->copy()->translatedFormat('jS M, Y');
    if ($usedDays <= 0) {
        $startsAt = $carbonParseStartAt->copy()->translatedFormat('jS M, Y');
    }

    if (! $currentSubscription->isExpired() && ! checkIfPlanIsInTrial($currentSubscription)) {
        $amountToPay = 0;

        $currentPlan = $currentSubscription->subscriptionPlan; // TODO: take fields from subscription

        // checking if the current active subscription plan has the same price and frequency in order to process the calculation for the proration
        $planPrice = $currentPlan->price;
        $planFrequency = $currentPlan->frequency;
        if ($planPrice != $currentSubscription->plan_amount || $planFrequency != $currentSubscription->plan_frequency) {
            $planPrice = $currentSubscription->plan_amount;
            $planFrequency = $currentSubscription->plan_frequency;
        }

        $frequencyDays = $planFrequency == SubscriptionPlan::MONTH ? 30 : 365;

        if($planFrequency == SubscriptionPlan::MONTH){
            $frequencyDays = 30;
        }elseif($planFrequency == SubscriptionPlan::YEAR){
            $frequencyDays = 365;
        }else{
            $frequencyDays = 36500;
        }

        $perDayPrice = round($planPrice / $frequencyDays, 2);

        $remainingBalance = round($planPrice - ($perDayPrice * $usedDays), 2);

        if ($remainingBalance < $subscriptionPlan->price) { // adjust the amount in plan
            $amountToPay = round($subscriptionPlan->price - $remainingBalance, 2);
        } else {
            $perDayPriceOfNewPlan = round($subscriptionPlan->price / $newPlanDays, 2);
            $totalExtraDays = round($remainingBalance / $perDayPriceOfNewPlan);

            $endsAt = Carbon::now()->addDays($totalExtraDays);
            $totalDays = $totalExtraDays;
        }

        return [
            'startDate' => $startsAt,
            'name' => $subscriptionPlan->name.' / '.$frequency,
            'trialDays' => $subscriptionPlan->trial_days,
            'remainingBalance' => $remainingBalance,
            'endDate' => $endsAt->translatedFormat('jS M, Y'),
            'amountToPay' => $amountToPay,
            'usedDays' => $usedDays,
            'totalExtraDays' => $totalExtraDays,
            'totalDays' => $totalDays,
        ];
    }

    return [
        'name' => $subscriptionPlan->name.' / '.$frequency,
        'trialDays' => $subscriptionPlan->trial_days,
        'startDate' => $startsAt,
        'endDate' => $endsAt->translatedFormat('jS M, Y'),
        'remainingBalance' => 0,
        'amountToPay' => $subscriptionPlan->price,
        'usedDays' => $usedDays,
        'totalExtraDays' => $totalExtraDays,
        'totalDays' => $totalDays,
    ];
}

function getPayPalSupportedCurrencies(): array
{
    return [
        'AUD', 'BRL', 'CAD', 'CNY', 'CZK', 'DKK', 'EUR', 'HKD', 'HUF', 'ILS', 'JPY', 'MYR', 'MXN', 'TWD', 'NZD', 'NOK',
        'PHP', 'PLN', 'GBP', 'RUB', 'SGD', 'SEK', 'CHF', 'THB', 'USD',
    ];
}

/**
 * @return mixed
 */
function getSubscription()
{
    static $subscription;

    if (empty($subscription)) {
        $subscription = Subscription::where('status', Subscription::ACTIVE)
            ->where('user_id', '=', getLogInUserId())
            ->first();
    }

    return $subscription;
}

function isSubscriptionExpired(): array
{
    $subscription = getSubscription();

    if ($subscription && $subscription->isExpired()) {
        return [
            'status' => true,
            'message' => 'Your current plan is expired, please choose new plan.',
        ];
    }

    if ($subscription == null) {
        return [
            'status' => true,
            'message' => 'Please choose a plan to continue the service.',
        ];
    }

    $subscriptionEndDate = Carbon::parse($subscription->trial_ends_at);
    $currentDate = Carbon::parse(Carbon::now())->format('Y-m-d');

    if ($subscription->trial_ends_at == null) {
        $subscriptionEndDate = Carbon::parse($subscription->ends_at);
    }

    $diffInDays = $subscriptionEndDate->diffInDays($currentDate);
    if ($diffInDays <= getSettingData()['plan_expire_notification'] && $diffInDays != 0) {
        $expirationMessage = "Your '{$subscription->subscriptionPlan->name}' is about to expired in {$diffInDays} days.";
    } else {
        $expirationMessage = "Your '{$subscription->subscriptionPlan->name}' is expired. Please choose a plan to continue the service.";
    }

    return [
        'status' => $subscriptionEndDate->diffInDays($currentDate) <= getSettingData()['plan_expire_notification'],
        'message' => $expirationMessage,
    ];
}

function getActiveEventsCount(): int
{
    static $activeEventCount;

    if (empty($activeEventCount)) {
        $activeEventCount = Event::whereUserId(getLogInUserId())->whereStatus(true)->count();
    }

    return $activeEventCount;
}

function getActiveScheduleEventsCount($userId): int
{
    static $activeScheduleEventCount;

    if (empty($activeScheduleEventCount)) {
        $activeScheduleEventCount = EventSchedule::whereUserId($userId)->whereStatus(true)->count();
    }

    return $activeScheduleEventCount;
}

/**
 * @return PlanFeature|Builder|Model|object|null
 */
function assignPlanFeatures($userId)
{
    $subscription = Subscription::where('status', Subscription::ACTIVE)->where('user_id', $userId)->first();
    $planFeature = PlanFeature::whereSubscriptionPlanId($subscription->subscription_plan_id)->first();

    return $planFeature;
}

function getUserSettings(): array
{
    static $userSetting;

    if (empty($userSetting)) {
        $userSetting = UserSetting::whereUserId(getLogInUserId())->pluck('value', 'key')->toArray();
    }

    return $userSetting;
}

/**
 * @return Repository|Application|HigherOrderBuilderProxy|mixed|string
 */
function paypalClientID($userId)
{
    $paypalClient = UserSetting::whereUserId($userId)->where('key', '=', 'paypal_client_id')->first();

    if (! empty($paypalClient) && ! empty($paypalClient->value)) {
        $paypalClientId = $paypalClient->value;
    } else {
        $paypalClientId = config('paypal.sandbox.client_id');
    }

    return $paypalClientId;
}

function getSuperAdminPaypalClientID()
{
    $paypalClient = Setting::where('key', '=', 'paypal_client_id')->first();

    if (! empty($paypalClient) && ! empty($paypalClient->value)) {
        $paypalClientID = $paypalClient->value;
    } else {
        $paypalClientID = config('paypal.sandbox.client_id');
    }

    return $paypalClientID;
}

/**
 * @return Repository|Application|HigherOrderBuilderProxy|mixed|string
 */
function paypalClientSecret($userId)
{
    $clientSecretKey = UserSetting::whereUserId($userId)->where('key', '=', 'paypal_secret')->first();

    if (! empty($clientSecretKey) && ! empty($clientSecretKey->value)) {
        $paypalClientSecret = $clientSecretKey->value;
    } else {
        $paypalClientSecret = config('paypal.sandbox.client_secret');
    }

    return $paypalClientSecret;
}

/**
 * @return Repository|Application|mixed
 */
function getSuperAdminPaypalClientSecret()
{
    $clientSecretKey = Setting::where('key', '=', 'paypal_secret')->first();

    if (! empty($clientSecretKey) && ! empty($clientSecretKey->value)) {
        $paypalClientSecret = $clientSecretKey->value;
    } else {
        $paypalClientSecret = config('paypal.sandbox.client_secret');
    }

    return $paypalClientSecret;
}

/**
 * @return Repository|Application|HigherOrderBuilderProxy|mixed|string
 */
function paypalMode($userId)
{
    $paypalModeRecord = UserSetting::whereUserId($userId)->where('key', '=', 'paypal_mode')->first();

    if (! empty($paypalModeRecord) && ! empty($paypalModeRecord->value)) {
        $paypalMode = $paypalModeRecord->value;
    } else {
        $paypalMode = config('paypal.mode');
    }

    return $paypalMode;
}

/**
 * @return Repository|Application|mixed
 */
function getSuperAdminPaypalMode()
{
    $paypalModeRecord = Setting::where('key', '=', 'paypal_mode')->first();

    if (! empty($paypalModeRecord) && ! empty($paypalModeRecord->value)) {
        $paypalMode = $paypalModeRecord->value;
    } else {
        $paypalMode = config('paypal.mode');
    }

    return $paypalMode;
}

function getEmptyDays($first_day): int
{
    $value = 7;
    if ($first_day == 'Monday') {
        $value = $value - 6;
    } else {
        if ($first_day == 'Tuesday') {
            $value = $value - 5;
        } else {
            if ($first_day == 'Wednesday') {
                $value = $value - 4;
            } else {
                if ($first_day == 'Thursday') {
                    $value = $value - 3;
                } else {
                    if ($first_day == 'Friday') {
                        $value = $value - 2;
                    } else {
                        if ($first_day == 'Saturday') {
                            $value = $value - 1;
                        } else {
                            $value = 0;
                        }
                    }
                }
            }
        }
    }

    return $value;
}

function getPriorityArray($arr): bool
{
    $flag = false;
    foreach ($arr as $value) {
        if ($flag) {
            continue;
        }
        if ($value['priority'] == 1) {
            $flag = true;
        }
    }

    return $flag;
}

function getTaskActiveCls($currentDate, $calendarDate): string
{
    return $currentDate == $calendarDate ? 'active' : '';
}

function getTaskShadowBorderCls($calendarTasks, $calendarDate): string
{
    if (! empty($calendarTasks[$calendarDate]) && getPriorityArray($calendarTasks[$calendarDate])) {
        return 'date-shadow date-border';
    } elseif (! empty($calendarTasks[$calendarDate])) {
        return 'date-shadow';
    }

    return '';
}

function getDayNumber($day): int
{
    if ($day == 'Monday') {
        $value = 1;
    } else {
        if ($day == 'Tuesday') {
            $value = 2;
        } else {
            if ($day == 'Wednesday') {
                $value = 3;
            } else {
                if ($day == 'Thursday') {
                    $value = 4;
                } else {
                    if ($day == 'Friday') {
                        $value = 5;
                    } else {
                        if ($day == 'Saturday') {
                            $value = 6;
                        } elseif ($day == 'Sunday') {
                            $value = 7;
                        }
                    }
                }
            }
        }
    }

    return $value;
}

/**
 * @return mixed
 */
function getCalendarView($userId, $key)
{
    $userSetting = UserSetting::whereUserId($userId)->where('key', '=', $key)->first();

    if (! empty($userSetting)) {
        return $userSetting->value;
    } else {
        $userSetting = UserSetting::create([
            'user_id' => $userId,
            'key' => $key,
            'value' => 1,
        ]);

        return $userSetting->value;
    }
}

function checkActiveSelectedClass($defaultDate, $period, $slotDaysArr): string
{
    if ($defaultDate == $period->translatedFormat('M d, Y') && in_array($period->format('Y-m-d'), $slotDaysArr)) {
        return 'active date-shadow';
    } elseif (in_array($period->format('Y-m-d'), $slotDaysArr)) {
        return 'date-shadow';
    } elseif ($defaultDate == $period->translatedFormat('M d, Y')) {
        return 'selected';
    }

    return '';
}

/**
 * @return mixed
 */
function version()
{
    $composerFile = file_get_contents('../composer.json');
    $composerData = json_decode($composerFile, true);
    $currentVersion = $composerData['version'];

    return $currentVersion;
}

function getSlotPeriodDates($period, $eventSchedules): array
{
    $days = [];
    $slotDays = [];
    foreach ($period as $date) {
        if ($date->format('l') == 'Monday') {
            $days[UserSchedule::Mon][] = $date->format('Y-m-d');
        } elseif ($date->format('l') == 'Tuesday') {
            $days[UserSchedule::Tue][] = $date->format('Y-m-d');
        } elseif ($date->format('l') == 'Wednesday') {
            $days[UserSchedule::Wed][] = $date->format('Y-m-d');
        } elseif ($date->format('l') == 'Thursday') {
            $days[UserSchedule::Thu][] = $date->format('Y-m-d');
        } elseif ($date->format('l') == 'Friday') {
            $days[UserSchedule::Fri][] = $date->format('Y-m-d');
        } elseif ($date->format('l') == 'Saturday') {
            $days[UserSchedule::Sat][] = $date->format('Y-m-d');
        } elseif ($date->format('l') == 'Sunday') {
            $days[UserSchedule::Sun][] = $date->format('Y-m-d');
        }
    }

    foreach ($eventSchedules as $eventSchedule) {
        if (isset($days[$eventSchedule->day_of_week])) {
            foreach ($days[$eventSchedule->day_of_week] as $day) {
                $slotDays[] = $day;
            }
        }
    }

    return $slotDays;
}

function getCountryCode($code): string
{
    return '+'.$code;
}

if (! function_exists('getCurrencies')) {
    function getCurrencies(): array
    {
        $currencies = Currency::get();

        foreach ($currencies as $currency) {
            $currencyListArr[strtolower($currency->currency_code)] = $currency->currency_icon.' - '.$currency->currency_name;
        }

        return $currencyListArr;
    }
}

/**
 * @return mixed
 */
function getUserRecord($userId)
{
    static $userRecord;

    if (empty($userRecord)) {
        $userRecord = User::find($userId);
    }

    return $userRecord;
}

/**
 * @return Builder|Model|mixed|object|null
 */
function getFirstEventAsPerLink($eventLink)
{
    static $firstEventRecord;

    if (empty($firstEventRecord)) {
        $firstEventRecord = Event::with('user')->where('event_link', $eventLink)->first();
    }

    return $firstEventRecord;
}

function getUserSettingTimeFormat($userId): string
{
    static $timeFormat;

    if (empty($timeFormat)) {
        $timeFormatCheck = UserSetting::whereUserId($userId)->where('key', 'time_format')->first();

        if (! empty($timeFormatCheck) && $timeFormatCheck->value) {
            $timeFormat = 'H:i';   // 24 hours format
        } else {
            $timeFormat = 'h:i A';   // 12 hours format
        }
    }

    return $timeFormat;
}

function getTimezoneWiseUserSlotTime($user, $time): string
{
    $time = explode(' - ', $time);
    $startAt = $time[0];
    $endAt = $time[1];

    $timeZoneName = isset($user->timezone) ?
        User::TIME_ZONE_ARRAY[$user->timezone] : User::TIME_ZONE_ARRAY[getTimeZone()];

    $startTime = Carbon::parse('20-04-1996 '.$startAt, $timeZoneName);
    $startTime->setTimezone(User::TIME_ZONE_ARRAY[getTimeZone()]);
    $startTime = $startTime->format(getUserSettingTimeFormat($user->id));

    $endTime = Carbon::parse('20-04-1996 '.$endAt, $timeZoneName);
    $endTime->setTimezone(User::TIME_ZONE_ARRAY[getTimeZone()]);
    $endTime = $endTime->format(getUserSettingTimeFormat($user->id));

    return $startTime.' - '.$endTime;
}

function getPayStackPublicKey($userID)
{
    $userPayStack = UserSetting::whereUserId($userID)
        ->where('key', '=', 'paystack_key')->first();

    if (! empty($userPayStack) && ! empty($userPayStack->value)) {
        return $userPayStack->value;
    } else {
        return config('services.paystack.key');
    }
}

function getPayStackSecretKey($userID)
{
    $userPayStack = UserSetting::whereUserId($userID)
        ->where('key', '=', 'paystack_secret')->first();

    if (! empty($userPayStack) && ! empty($userPayStack->value)) {
        return $userPayStack->value;
    } else {
        return config('services.paystack.secret_key');
    }
}

function getCurrentCurrency()
{
    /** @var Setting $currentCurrency */
    static $currentCurrency;

    if (empty($currentCurrency)) {
        $currentCurrency = Setting::where('key', 'currency')->first();
    }

    return $currentCurrency->value;
}

function getPaymentCredentials($key)
{
    $credentialValue ='';

    $query = Setting::pluck('value','key')->toArray();

    if (!empty($query) && array_key_exists($key, $query)) {
        $credentialValue = $query[$key];
    }

    return $credentialValue;
}

function getUserPaymentCredentials($key)
{
    $credentialValue ='';

    $query = UserSetting::pluck('value','key')->toArray();

    if(!empty($query)){
        $credentialValue = $query[$key];
    }

    return $credentialValue;
}

if(!function_exists('subscriptionPaymentTypes')){
    function subscriptionPaymentTypes(){
        $paymentType = [];

        $stripe = getPaymentCredentials('stripe_checkbox_btn');
        $paypal = getPaymentCredentials('paypal_checkbox_btn');
        $payStack = getPaymentCredentials('paystack_checkbox_btn');
        $razorpay = getPaymentCredentials('razorpay_checkbox_btn');

        if(!empty($stripe)){
            $paymentType[1] = 'Stripe';
        }

        if(!empty($paypal)){
            $paymentType[2] = 'PayPal';
        }

        if(!empty($payStack)){
            $paymentType[4] = 'Paystack';
        }

        if(!empty($razorpay)){
            $paymentType[5] = 'RazorPay';
        }

        $paymentType[3] = 'Manually';

        return  $paymentType;

    }

    //Admin Razorpay Key
    function getSuperAdminRazorpayKey()
    {
        $adminRazorpay = Setting::where('key', '=', 'razorpay_key')->first();

        if (! empty($adminRazorpay) && ! empty($adminRazorpay->value)) {
            return $adminRazorpay->value;
        }
    }

     //Admin Razorpay Sceret Key
     function getSuperAdminRazorpaySecretKey()
     {
         $adminRazorSecretpay = Setting::where('key', '=', 'razorpay_secret')->first();

         if (! empty($adminRazorSecretpay) && ! empty($adminRazorSecretpay->value)) {
             return $adminRazorSecretpay->value;
         }
     }

    //Supported Currenices of Razorpay
    function getRazorPaySupportedCurrencies(): array
    {
        return [
            'USD', 'EUR', 'GBP', 'SGD', 'AED', 'AUD', 'CAD', 'CNY', 'SEK', 'NZD', 'MXN', 'HKD', 'NOK', 'RUB', 'ALL', 'AMD',
            'ARS', 'AWG', 'BBD', 'BDT', 'BMD', 'BND', 'BOB', 'BSD', 'BWP', 'BZD', 'CHF', 'COP', 'CRC', 'CUP', 'CZK', 'DKK',
            'DOP', 'DZD', 'EGP', 'ETB', 'FJD', 'GIP', 'GMD', 'GTQ', 'GYD', 'HKD', 'HNL', 'HRK', 'HTG', 'HUF', 'IDR', 'ILS',
            'INR', 'JMD', 'KES', 'KGS', 'KHR', 'KYD', 'KZT', 'LAK', 'LBP', 'LKR', 'LRD', 'LSL', 'MAD', 'MDL', 'MKD', 'MMK',
            'MNT', 'MOP', 'MUR', 'MVR', 'MWK', 'MYR', 'NAD', 'NGN', 'NIO', 'NOK', 'NPR', 'PEN', 'PGK', 'PHP', 'PKR', 'QAR',
            'SAR', 'SCR', 'SLL', 'SOS', 'SSP', 'SVC', 'SZL', 'THB', 'TTD', 'TZS', 'UYU', 'UZS', 'YER', 'ZAR', 'GHS',
        ];
    }

    //User Razorpay Key
    function getAdminRazorpayKey($userId)
    {
        $userRazorpay = UserSetting::whereUserId($userId)->where('key', '=', 'razorpay_key')->first();

        if (! empty($userRazorpay) && ! empty($userRazorpay->value)) {
            return $userRazorpay->value;
        }
    }

    //User Razorpay Sceret Key
    function getAdminRazorpaySecretKey($userId)
    {
        $userRazorSecretpay = UserSetting::whereUserId($userId)->where('key', '=', 'razorpay_secret')->first();

        if (! empty($userRazorSecretpay) && ! empty($userRazorSecretpay->value)) {
            return $userRazorSecretpay->value;
        }
    }
}


function getSuperAdminSettingKeyValue($key)
{
    $setting = Setting::where('key', '=', $key)->value('value');

    return $setting;
}
