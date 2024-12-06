<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') | {{ getSettingData()['application_name'] }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset(getSettingData()['favicon']) }}" type="image/png">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>

    <!-- General CSS Files -->
    <link href="{{ asset('web/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('web/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <!-- CSS Libraries -->
    @yield('page_css')
    @yield('css')
</head>
@php
    $styleCss = 'style';
@endphp
<body data-bs-offset="200"
      class="bg-white position-relative header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed">
@stack('sidebar_js')
<div class="main-content">

    @yield('content')

    <footer>
        <div class="container-fluid padding-0">
        </div>
    </footer>
</div>

<!-- Scripts -->
<script src="{{ asset('web/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('web/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('web/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>
<script src="{{ asset('web/plugins/custom/typedjs/typedjs.bundle.js') }}"></script>
<script src="{{ asset('web/js/custom/landing.js') }}"></script>
<script src="{{ asset('web/js/custom/pages/company/pricing.js') }}"></script>

@yield('page_js')
@yield('scripts')
<script>
    $(document).ready(function () {
        $('.alert').delay(5000).slideUp(300);
    });
</script>
</body>
</html>
