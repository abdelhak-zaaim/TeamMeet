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
    <!-- CSS Libraries -->
    @yield('css')
    <link href="{{ mix('assets/css/front/custom.css') }}" rel="stylesheet" type="text/css"/>
</head>
@php
    $styleCss = 'style';
@endphp
<body style="overflow-x:hidden;">
<div class="d-flex flex-column flex-root vh-100">
    <div class="d-flex flex-row flex-column-fluid">
        <div class="d-flex flex-column flex-row-fluid">
            <div class="content d-flex flex-column flex-column-fluid">
                <div class='p-sm-10 flex-column-fluid'>
                    @yield('content')
                </div>
            </div>
            <div class='container-fluid'>
                @include('stepper.footer')
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/new-theme.js') }}"></script>
<script src="{{ asset('assets/js/third-party.js') }}"></script>
<script src="{{ mix('assets/js/custom/helper.js')}}"></script>
<script src="{{ mix('assets/js/custom/custom.js') }}"></script>
<script src="{{ asset('messages.js') }}"></script>
<script>
    $(document).ready(function () {
        let currentLocale = "{{ Config::get('app.locale') }}"
        if (currentLocale == '') {
            currentLocale = 'en'
        }
        Lang.setLocale(currentLocale)
        $('.alert').delay(5000).slideUp(300)
    })
</script>
@routes
@yield('page_js')
@yield('scripts')
</body>
</html>

