<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') | {{ getSettingData()['application_name'] }}</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset(getSettingData()['favicon']) }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- General CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/new-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('assets/css/pages.css') }}">
    <!-- CSS Libraries -->
    @stack('css')
    @yield('page_css')
    @livewireStyles
</head>
@php
    $styleCss = 'style';
@endphp
<body class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed">
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed authImage">
        @yield('content')
    </div>
</div>
<footer>
    <div class="container-fluid padding-0">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-6">
                <div class="copyright text-center text-muted">
                    All rights reserved &copy; {{ date('Y') }}
                    <a href="{{ config('app.url') }}" class="font-weight-bold ml-1"
                       target="_blank">{{ getSettingData()['application_name'] }}</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Scripts -->
@livewireScripts
<script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js"
        data-turbolinks-eval="false" data-turbo-eval="false"></script>
<script src="{{ asset('messages.js') }}"></script>
<script>
    let currentLocale = "{{ Config::get('app.locale') }}"
    if (currentLocale == '') {
        currentLocale = 'en'
    }

    Lang.setLocale(currentLocale)

    let defaultCountryCodeValue = "{{ getSettingData()['default_country_code'] }}"
</script>
<script src="{{ asset('assets/js/new-theme.js') }}"></script>
<script src="{{ asset('assets/js/third-party.js') }}"></script>
<script src="{{ asset('assets/js/evo-calendar.js') }}"></script>
<script src="{{ asset('assets/js/front-pages.js') }}"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
@routes
@stack('scripts')
@yield('page_js')
<script>
    $(document).ready(function () {
        $('.alert').delay(5000).slideUp(300)
    })
</script>
</body>
</html>

