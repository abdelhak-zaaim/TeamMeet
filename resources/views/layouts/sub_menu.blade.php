@if(getLogInUser()->hasRole('admin'))
    <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('admin/dashboard*')) ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/dashboard*') ? 'active' : ''  }}"
           href="{{ route('admin.dashboard') }}">
            {{ __('messages.dashboard') }}
        </a>
    </li>
    <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('admin/admins*')) ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/admins*') ? 'active' : ''  }}" href="{{ route('admins.index') }}">
            {{ __('messages.admins') }}
        </a>
    </li>
    <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('admin/users*')) ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/users*') ? 'active' : ''  }}" href="{{ route('users.index') }}">
            {{ __('messages.users') }}
        </a>
    </li>
    <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('admin/personal-experiences*')) ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/personal-experiences*') ? 'active' : ''  }}"
           href="{{ route('personal-experiences.index') }}">
            {{ __('messages.personal_experiences') }}
        </a>
    </li>
    <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('admin/settings*')) && (!Request::is('admin/currencies*'))  ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/settings*') ? 'active' : ''  }}"
           href="{{ route('settings.index') }}">
            {{ __('messages.settings') }}
        </a>
    </li>
    <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('admin/settings*')) && (!Request::is('admin/currencies*')) ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/currencies*') ? 'active' : ''  }}"
           href="{{ route('currencies.index') }}">
            {{ __('messages.currencies') }}
        </a>
    </li>
    <li class="nav-item position-relative me-lg-1 mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('admin/subscription-plans*')) ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/subscription-plans*') ? 'active' : ''  }}"
           href="{{ route('subscription-plans.index') }}">
            {{ __('messages.subscription_plans') }}
        </a>
    </li>
    <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('admin/cash-payments*')) ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/cash-payments*') ? 'active' : ''  }}"
           href="{{ route('cash.payments.index') }}">
            {{ __('messages.cash_payments') }}
        </a>
    </li>
    <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('admin/subscription-transactions*')) && (!Request::is('admin/transactions*'))  ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/transactions*') ? 'active' : ''  }}"
           href="{{ route('transactions.index') }}">
            {{ __('messages.schedule_transactions') }}
        </a>
    </li>
    <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('admin/subscription-transactions*')) && (!Request::is('admin/transactions*')) ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/subscription-transactions*')? 'active' : ''  }}"
           href="{{ route('subscription.transactions.index') }}">
            {{ __('messages.subscription_transactions') }}
        </a>
    </li>
    <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('admin/front-cms*')) && (!Request::is('admin/front-service*')) && (!Request::is('admin/brands*')) && (!Request::is('admin/front-testimonials*')) && (!Request::is('admin/faqs*')) && (!Request::is('admin/main-reasons*')) && (!Request::is('admin/about-us*')) ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/front-cms*') ? 'active' : ''  }}"
           href="{{ route('front.cms.index') }}">
            {{ __('messages.front_cms') }}
        </a>
    </li>
    <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('admin/front-service*')) &&  (!Request::is('admin/front-cms*'))  && (!Request::is('admin/brands*')) && (!Request::is('admin/front-testimonials*')) && (!Request::is('admin/faqs*')) && (!Request::is('admin/about-us*')) && (!Request::is('admin/main-reasons*')) ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/front-service*') && (!Request::is('admin/main-reasons*'))? 'active' : ''  }}"
           href="{{ route('front.service.index') }}">
            {{ __('messages.services') }}
        </a>
    </li>
    <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0  {{ (!Request::is('admin/front-cms*')) && (!Request::is('admin/brands*')) && (!Request::is('admin/front-service*')) && (!Request::is('admin/front-testimonials*')) && (!Request::is('admin/faqs*')) && (!Request::is('admin/main-reasons*'))&& (!Request::is('admin/about-us*')) ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/brands*') ? 'active' : ''  }}"
           href="{{ route('brands.index') }}">
            {{ __('messages.front_brands') }}
        </a>
    </li>
    <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('admin/front-cms*')) && (!Request::is('admin/front-service*')) && (!Request::is('admin/brands*')) && (!Request::is('admin/front-testimonials*')) && (!Request::is('admin/faqs*')) && (!Request::is('admin/main-reasons*')) && (!Request::is('admin/about-us*')) ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/front-testimonials*') ? 'active' : ''  }}"
           href="{{ route('front-testimonials.index') }}">
            {{ __('messages.front_testimonials') }}
        </a>
    </li>
    <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('admin/front-cms*')) && (!Request::is('admin/front-service*')) && (!Request::is('admin/brands*')) && (!Request::is('admin/front-testimonials*')) && (!Request::is('admin/faqs*')) && (!Request::is('admin/main-reasons*')) && (!Request::is('admin/about-us*')) ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/faqs*') ? 'active' : ''  }}" href="{{ route('faqs.index') }}">
            {{ __('messages.faqs') }}
        </a>
    </li>
    <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{(!Request::is('admin/front-cms*')) && (!Request::is('admin/front-service*')) && (!Request::is('admin/brands*')) && (!Request::is('admin/front-testimonials*')) && (!Request::is('admin/faqs*')) && (!Request::is('admin/main-reasons*')) && (!Request::is('admin/about-us*')) ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/main-reasons*') ? 'active' : ''  }}"
           href="{{ route('main.reasons.index') }}">
            {{ __('messages.main_reasons') }}
        </a>
    </li>
    <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{(!Request::is('admin/front-cms*')) && (!Request::is('admin/front-service*')) && (!Request::is('admin/brands*')) && (!Request::is('admin/front-testimonials*')) && (!Request::is('admin/faqs*')) && (!Request::is('admin/main-reasons*')) &&(!Request::is('admin/about-us*')) ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/about-us*') ? 'active' : ''  }}"
           href="{{ route('about.us.index') }}">
            {{ __('messages.about_us.about_us') }}
        </a>
    </li>
    <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('admin/enquiries*')) ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/enquiries*') ? 'active' : ''  }}"
           href="{{ route('enquiries.index') }}">
            {{ __('messages.enquiries') }}
        </a>
    </li>
    <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('admin/subscribers*')) ? 'd-none' : '' }}">
        <a class="nav-link p-0 {{ Request::is('admin/subscribers*') ? 'active' : ''  }}"
           href="{{ route('subscribers.index') }}">
            {{ __('messages.subscribers') }}
        </a>
    </li>
@endif
@role('user')
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('dashboard*')) ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('dashboard*') ? 'active' : ''  }}" href="{{ route('dashboard') }}">
        {{ __('messages.dashboard') }}
    </a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0  {{ (!Request::is('events*'))  ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('events*') ? 'active' : ''  }}"
       href="{{ route('events.index') }}">
        {{ __('messages.events') }}
    </a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('schedules*')) ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('schedules*') ? 'active' : ''  }}" href="{{ route('schedules.index') }}">
        {{ __('messages.schedules') }}
    </a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('scheduled-events*')) ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('scheduled-events*') ? 'active' : ''  }}"
       href="{{ route('scheduled-events.index') }}">
        {{ __('messages.schedule_events') }}
    </a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('transactions*')) && (!Request::is('subscription-transactions*')) ? 'd-none' : '' }}">
    <a class="nav-link p-0   {{ Request::is('transactions*') ? 'active' : ''  }}"
       href="{{ route('user.transactions.index') }}">
        {{ __('messages.schedule_transactions') }}
    </a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('transactions*')) && (!Request::is('subscription-transactions*')) ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('subscription-transactions*') ? 'active' : ''  }}"
       href="{{ route('user.subscription.transactions.index') }}">
        {{ __('messages.subscription_transactions') }}
    </a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('subscription-plans*') && !Request::is('choose-payment-type*')) ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('subscription-plans*') || Request::is('choose-payment-type*') ? 'active' : ''  }}"
       href="{{ route('subscription.pricing.plans.index') }}">
        {{ __('messages.subscription_plan.subscription_plans') }}
    </a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('connect-google-calendar*')) ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('connect-google-calendar*') ? 'active' : ''  }}"
       href="{{ route('google.calendar.index') }}">
        {{ __('messages.setting.connect_google_calendar') }}
    </a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('settings*')) ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('settings*') ? 'active' : ''  }}"
       href="{{ route('user.settings') }}">
        {{ __('messages.settings') }}
    </a>
</li>
@endrole
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ (!Request::is('profile/edit*')) ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('profile/edit*') ? 'active' : ''  }}" href="{{ route('profile.setting') }}">
        {{ __('messages.user.profile_details') }}
    </a>
</li>
