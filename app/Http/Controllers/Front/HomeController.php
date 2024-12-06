<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\AppBaseController;
use App\Models\Brand;
use App\Models\Faq;
use App\Models\FrontTestimonial;
use App\Models\MainReason;
use App\Models\Service;
use App\Models\SubscriptionPlan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;

class HomeController extends AppBaseController
{
    /**
     * @return Application|Factory|View
     */
    public function home(): \Illuminate\View\View
    {
        $data['frontTestimonials'] = FrontTestimonial::with('media')->get();
        $frontCMSSettings = getFrontCMSSetting();
        $mainReasons = MainReason::toBase()->pluck('value', 'key')->toArray();
        $data['brands'] = Brand::with('media')->latest()->get()->take(6);
        $data['services'] = Service::with('media')->pluck('value', 'key')->toArray();
        $data['registeredUsersCount'] = getRegisteredUsersCount();
        $data['eventsCreatedCount'] = getEventsCreatedCount();
        $data['scheduledEventsCount'] = getScheduledEventsCount();

        return view('fronts.front_index', compact('data', 'frontCMSSettings', 'mainReasons'));
    }

    /**
     * @return Application|Factory|View
     */
    public function pricing(): \Illuminate\View\View
    {
        $frontCMSSettings = getFrontCMSSetting();
        $subscriptionPricingMonthPlans = SubscriptionPlan::with('planFeature')->where('frequency', '=',
            SubscriptionPlan::MONTH)
            ->get();
        $subscriptionPricingYearPlans = SubscriptionPlan::with('planFeature')->where('frequency', '=',
            SubscriptionPlan::YEAR)
            ->get();
        $subscriptionPricingUnlimitedPlans = SubscriptionPlan::with('planFeature')->where('frequency', '=',
            SubscriptionPlan::UNLIMITED)
            ->get();
        $data['registeredUsersCount'] = getRegisteredUsersCount();
        $data['eventsCreatedCount'] = getEventsCreatedCount();
        $data['scheduledEventsCount'] = getScheduledEventsCount();

        return view('fronts.pricing',
            compact('frontCMSSettings', 'subscriptionPricingMonthPlans', 'subscriptionPricingYearPlans', 'data', 'subscriptionPricingUnlimitedPlans'));
    }

    /**
     * @return Application|Factory|View
     */
    public function aboutUs(): \Illuminate\View\View
    {
        $frontCMSSettings = getFrontCMSSetting();
        $data['registeredUsersCount'] = getRegisteredUsersCount();
        $data['eventsCreatedCount'] = getEventsCreatedCount();
        $data['scheduledEventsCount'] = getScheduledEventsCount();

        return view('fronts.about_us', compact('frontCMSSettings', 'data'));
    }

    /**
     * @return Application|Factory|View
     */
    public function contactUs(): \Illuminate\View\View
    {
        $frontCMSSettings = getFrontCMSSetting();
        $services = Service::with('media')->pluck('value', 'key')->toArray();

        return view('fronts.contact_us', compact('frontCMSSettings', 'services'));
    }

    /**
     * @return Application|Factory|View
     */
    public function faq(): \Illuminate\View\View
    {
        $frontCMSSettings = getFrontCMSSetting();
        $faqs = Faq::toBase()->latest()->get();

        return view('fronts.faqs', compact('frontCMSSettings', 'faqs'));
    }

    /**
     * @return Application|Factory|View
     */
    public function termCondition(): \Illuminate\View\View
    {
        $frontCMSSettings = getFrontCMSSetting();

        return view('fronts.terms_conditions', compact('frontCMSSettings'));
    }

    /**
     * @return Application|Factory|View
     */
    public function privacyPolicy(): \Illuminate\View\View
    {
        $frontCMSSettings = getFrontCMSSetting();

        return view('fronts.privacy_policy', compact('frontCMSSettings'));
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function emailSignUp(Request $request): RedirectResponse
    {
        $email = $request->get('email');

        return redirect(route('sign.up'))->with('email', $email);
    }

    public function changeLanguage(Request $request): JsonResponse
    {
        Session::put('languageName', $request->input('languageName'));

        return $this->sendSuccess(__('messages.success_message.language_changed'));
    }

    /**
     * @return Application|Factory|View
     */
    public function featureAvailability(): \Illuminate\View\View
    {
        return view('menu_feature.index');
    }
}
