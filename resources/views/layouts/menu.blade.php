@if(getLogInUser()->hasRole('admin'))
    <li class="nav-item {{ Request::is('admin/dashboard*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center" href="{{ route('admin.dashboard') }}">
            <span class="aside-menu-icon pe-3"><i class="fa-solid fa-circle-dot fs-3"></i></span>
            <span class="aside-menu-title">{{ __('messages.dashboard') }}</span>
        </a>
    </li>
    <li class="nav-item {{ Request::is('admin/admins*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center" href="{{ route('admins.index') }}">
            <span class="aside-menu-icon pe-3"><i class="fas fa-user fs-3"></i></span>
            <span class="aside-menu-title">{{ __('messages.admins') }}</span>
        </a>
    </li>
    <li class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3" href="{{ route('users.index') }}">
        <span class="aside-menu-icon pe-3">
            <i class="fas fa-users fs-4"></i>
        </span>
            <span class="aside-menu-title">{{__('messages.users')}}</span>
        </a>
    </li>
    <li class="nav-item {{ Request::is('admin/personal-experiences*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3" href="{{ route('personal-experiences.index') }}">
        <span class="aside-menu-icon pe-3">
            <i class="fas fa-user fs-3"></i>
        </span>
            <span class="aside-menu-title">{{__('messages.personal_experiences')}}</span>
        </a>
    </li>
    <li class="nav-item {{ (Request::is('admin/enquiries*') ? 'active' : '') }}">
        <a class="nav-link d-flex align-items-center py-3"
           href="{{ route('enquiries.index') }}">
        <span class="aside-menu-icon pe-3">
            <i class="fas fa-question-circle fs-3"></i>
        </span>
            <span class="aside-menu-title">{{ __('messages.enquiries') }}</span>
        </a>
    </li>
    <li class="nav-item {{ (Request::is('admin/subscribers*') ? 'active' : '') }}">
        <a class="nav-link d-flex align-items-center py-3"
           href="{{ route('subscribers.index') }}">
        <span class="aside-menu-icon pe-3">
            <i class="fab fa-stripe-s fs-3"></i>
        </span>
            <span class="aside-menu-title">{{ __('messages.subscribers') }}</span>
        </a>
    </li>
    <li class="nav-item {{ Request::is('admin/subscription-plans*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3"
           href="{{ route('subscription-plans.index') }}">
        <span class="aside-menu-icon pe-3">
            <i class="fas fa-rupee-sign fs-3"></i>
        </span>
            <span class="aside-menu-title">{{ __('messages.subscription_plans') }}</span>
        </a>
    </li>
    <li class="nav-item menu-search {{ (Request::is('admin/cash-payments*')) ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3"
           href="{{ route('cash.payments.index') }}">
        <span class="aside-menu-icon pe-3">
            <i class="fas fa-money-bill"></i>
        </span>
            <span class="aside-menu-title">{{ __('messages.cash_payments') }}</span>
        </a>
    </li>
    <li class="nav-item menu-search {{ (Request::is('admin/transactions*')) || Request::is('admin/subscription-transactions*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3"
           href="{{ route('transactions.index') }}">
        <span class="aside-menu-icon pe-3">
            <i class="fas fa-money-bill-wave"></i>
        </span>
            <span class="aside-menu-title">{{ __('messages.transactions') }}</span>
        </a>
    </li>
    <li class="nav-item {{ (Request::is('admin/front-cms*') || Request::is('admin/front-service*') || Request::is('admin/brands*') || Request::is('admin/front-testimonials*') || Request::is('admin/faqs*') || Request::is('admin/main-reasons*') || Request::is('admin/about-us*') ? 'active' : '') }}">
        <a class="nav-link d-flex align-items-center py-3"
           href="{{ route('front.cms.index') }}">
        <span class="aside-menu-icon pe-3">
            <i class="fas fa-tasks fs-3"></i>
        </span>
            <span class="aside-menu-title">{{__('messages.front_cms')}}</span>
        </a>
    </li>
    <li class="nav-item {{ (Request::is('admin/settings*') || Request::is('admin/currencies*') ? 'active' : '') }}">
        <a class="nav-link d-flex align-items-center py-3"
           href="{{ route('settings.index') }}">
        <span class="aside-menu-icon pe-3">
            <i class="fas fa-cogs fs-4"></i>
        </span>
            <span class="aside-menu-title">{{__('messages.settings')}}</span>
        </a>
    </li>
@endif
@role('user')
<li class="nav-item {{ Request::is('dashboard*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3"
       href="{{ route('dashboard') }}">
        <span class="aside-menu-icon pe-3">
            <i class="fa-solid fa-circle-dot fs-3"></i>
        </span>
        <span class="aside-menu-title">{{ __('messages.dashboard') }}</span>
    </a>
</li>
<li class="nav-item {{ Request::is('events*') ? 'active' : '' }}" href="{{ route('events.index') }}">
    <a class="nav-link d-flex align-items-center py-3"
       href="{{ route('events.index') }}">
        <span class="aside-menu-icon pe-3">
            <i class="far fa-calendar-alt fs-3"></i>
        </span>
        <span class="aside-menu-title">{{ __('messages.events') }}</span>
    </a>
</li>
<li class="nav-item {{ Request::is('schedules*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3"
       href="{{ route('schedules.index') }}">
        <span class="aside-menu-icon pe-3">
            <i class="far fa-calendar fs-3"></i>
        </span>
        <span class="aside-menu-title">{{ __('messages.schedules') }}</span>
    </a>
</li>
<li class="nav-item {{ Request::is('scheduled-events*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3"
       href="{{ route('scheduled-events.index') }}">
        <span class="aside-menu-icon pe-3">
            <i class="fas fa-calendar-day fs-3"></i>
        </span>
        <span class="aside-menu-title">{{ __('messages.schedule_events') }}</span>
    </a>
</li>
<li class="nav-item menu-search {{ (Request::is('transactions*')) || Request::is('subscription-transactions*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3"
       href="{{ route('user.transactions.index') }}">
        <span class="aside-menu-icon pe-3">
            <i class="fas fa-money-bill-wave"></i>
        </span>
        <span class="aside-menu-title">{{ __('messages.transactions') }}</span>
    </a>
</li>
<li class="nav-item {{ Request::is('connect-google-calendar*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3"
       href="{{ route('google.calendar.index') }}">
        <span class="aside-menu-icon pe-3">
            <i class="fas fa-calendar-day fs-3"></i>
        </span>
        <span class="aside-menu-title">{{__('messages.setting.connect_google_calendar')}}</span>
    </a>
</li>
<li class="nav-item {{ (Request::is('settings*')  ? 'active' : '') }}">
    <a class="nav-link d-flex align-items-center py-3"
       href="{{ route('user.settings') }}">
        <span class="aside-menu-icon pe-3">
            <i class="fas fa-cogs fs-4"></i>
        </span>
        <span class="aside-menu-title">{{__('messages.settings')}}</span>
    </a>
</li>
@endrole
