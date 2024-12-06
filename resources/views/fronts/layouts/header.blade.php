<header class="position-relative">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-1 col-4">
                <a href="{{ url('/') }}" class="header-logo d-block">
                    <img src="{{ asset(getSettingData()['logo']) }}" class="logo img-fluid h-100" loading="lazy">
                </a>
            </div>
            <div class="col-lg-11 col-8">
                <nav class="navbar navbar-expand-lg navbar-light justify-content-end py-0">
                    <button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end front-top-menu" id="navbarNav">
                        <ul class="navbar-nav align-items-center py-2 py-lg-0">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('/*') ? 'active' : '' }}" aria-current="page"
                                    href="{{ route('frontHome') }}">{{ __('messages.home') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('pricing*') ? 'active' : '' }}"
                                    href="{{ route('pricing') }}">{{ __('messages.pricing') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('about-us*') ? 'active' : '' }}"
                                    href="{{ route('about-us') }}">{{ __('messages.about_us.about_us') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('contact-us*') ? 'active' : '' }}"
                                    href="{{ route('contact-us') }}">{{ __('messages.contact_us') }}</a>
                            </li>
                            <li class="nav-item">
                                <div class="dropdown ps-3 ps-lg-1 ms-0 ms-lg-2">
                                    <a class="nav-link dropdown-toggle hide-arrow ps-2" href="#" role="button"
                                        id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ __('messages.language') }}
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        @foreach (getUserLanguages() as $key => $value)
                                            <li class="languageSelection" data-prefix-value="{{ $key }}"><a
                                                    href="javascript:void(0)"
                                                    class="dropdown-item {{ checkLanguageSession() == $key ? 'active' : '' }}">{{ $value }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <div class="text-lg-end header-btn-grp ms-xxl-5" data-turbo="false">
                            @if (getLogInUser())
                                @if (getLogInUser()->hasRole('admin'))
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary mb-3 mb-lg-0"
                                        data-turbo="false">{{ __('messages.dashboard') }}</a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="btn btn-primary mb-3 mb-lg-0"
                                        data-turbo="false">{{ __('messages.dashboard') }}</a>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                    class="btn btn-outline-primary me-xxl-3 me-2 mb-3 mb-lg-0">{{ __('messages.login') }}</a>
                            @endif
                            @if (!getLogInUser())
                                <a href="{{ route('sign.up') }}"
                                    class="btn btn-primary mb-3 mb-lg-0">{{ __('messages.sign_up') }}</a>
                            @endif
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
