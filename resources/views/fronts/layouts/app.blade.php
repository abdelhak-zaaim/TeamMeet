<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('front-title') | {{ getSettingData()['application_name'] }}</title>
    <link rel="icon" type="image/png" sizes="56x56" href="{{ asset(getSettingData()['favicon']) }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="{{ mix('assets/css/front-third-party.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('assets/css/front-pages.css') }}">
    <link href="{{ asset('front/css/layout.css') }}" rel="stylesheet" type="text/css">
    @yield('front-css')
    @livewireStyles
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js"
        data-turbolinks-eval="false" data-turbo-eval="false"></script>
    <script src="{{ mix('assets/js/front-third-party.js') }}"></script>
    <script src="{{ mix('assets/js/front-page.js') }}"></script>
    <script data-turbo-eval="false">
        let csrfToken = "{{ csrf_token() }}"
        let getLoggedInUserdata = "{{ getLogInUser() }}"
    </script>
    @routes
</head>

<body>
    <div>
        @include('fronts.layouts.header')
        @yield('front-content')
        @include('fronts.layouts.footer')
    </div>
</body>

</html>
