const mix = require('laravel-mix')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').
    postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])

// copy folder
mix.copyDirectory('resources/assets/images', 'public/assets/images')
mix.copyDirectory('resources/theme/images', 'public/images')
mix.copyDirectory('resources/theme/webfonts', 'public/assets/webfonts')
mix.copyDirectory('resources/theme/fonts', 'public/fonts')
mix.copyDirectory('node_modules/intl-tel-input/build/img', 'public/assets/img')
mix.copyDirectory('node_modules/slick-carousel/slick/fonts',
    'public/front/js/slick/fonts')

mix.styles('resources/theme/css/style.css', 'public/css/style.css')
mix.sass('resources/assets/css/front-custom.scss',
    'public/assets/css/front-custom.css').version()

// front third party CSS
mix.styles([
    'public/front/css/bootstrap.css',
    'node_modules/toastr/build/toastr.min.css',
    'node_modules/slick-carousel/slick/slick.css',
    'node_modules/slick-carousel/slick/slick-theme.css',
], 'public/assets/css/front-third-party.css')

// front pages css
mix.styles([
    'public/front/css/custom.css',
    'public/assets/css/front-custom.css'
], 'public/assets/css/front-pages.css')

// new theme CSS
mix.styles([
    'resources/theme/css/third-party.css',
    'resources/theme/css/plugins.css',
], 'public/assets/css/new-theme.css')

// third party CSS
mix.styles([
    'node_modules/@simonwep/pickr/dist/themes/nano.min.css',
    'node_modules/intl-tel-input/build/css/intlTelInput.css',
    'node_modules/quill/dist/quill.snow.css',
    'node_modules/quill/dist/quill.bubble.css',
    'node_modules/evo-calendar/evo-calendar/css/evo-calendar.css',
    'node_modules/evo-calendar/evo-calendar/css/evo-calendar.royal-navy.css',
], 'public/assets/css/third-party.css')

// new theme JS
mix.scripts([
    'resources/theme/js/vendor.js',
    'resources/theme/js/plugins.js',
    'node_modules/@simonwep/pickr/dist/pickr.min.js',
], 'public/assets/js/new-theme.js').version()

// third party JS
mix.scripts([
    'node_modules/moment-timezone/builds/moment-timezone-with-data.js',
    'node_modules/intl-tel-input/build/js/utils.js',
    'node_modules/intl-tel-input/build/js/intlTelInput.js',
    'node_modules/quill/dist/quill.min.js',
    'node_modules/evo-calendar/evo-calendar/js/evo-calendar.js',
], 'public/assets/js/third-party.js').version()

// common page CSS
mix.scripts([
    'resources/assets/css/custom.scss',
    'resources/assets/css/calendars/custom-calendar.css',
    'resources/assets/css/custom-livewire-calendar/custom-livewire-calendar.css',
], 'public/assets/css/pages.css').version()

// common page JS
mix.js([
    'resources/assets/js/turbo.js',
    'resources/assets/js/custom/helper.js',
    'resources/assets/js/custom/custom.js',
    'resources/assets/js/users/user.js',
    'resources/assets/js/users/user-create-edit.js',
    'resources/assets/js/users/user-profile.js',
    'resources/assets/js/personal_experiences/personal-experience.js',
    'resources/assets/js/custom/phone-number-country-code.js',
    'resources/assets/js/events/events.js',
    'resources/assets/js/events/create-edit.js',
    'resources/assets/js/events/event-schedule.js',
    'resources/assets/js/schedules/schedule.js',
    'resources/assets/js/schedule_events/schedule-event.js',
    'resources/assets/js/events/event-schedule-datatable.js',
    'resources/assets/js/front/front_testimonials/front_testimonials.js',
    'resources/assets/js/front/front_testimonials/create-edit.js',
    'resources/assets/js/front/cms/create.js',
    'resources/assets/js/front/services/services.js',
    'resources/assets/js/front/faqs/faqs.js',
    'resources/assets/js/front/faqs/create-edit.js',
    'resources/assets/js/front/main_reason/main_reason.js',
    'resources/assets/js/subscription_plans/subscription_plan.js',
    'resources/assets/js/subscription_plans/create-edit.js',
    'resources/assets/js/subscription_plans/plan_features.js',
    'resources/assets/js/brands/brands.js',
    'resources/assets/js/enquiries/enquiry.js',
    'resources/assets/js/subscribers/subscriber.js',
    'resources/assets/js/front/about_us/create-edit.js',
    'resources/assets/js/front/contact-us.js',
    'resources/assets/js/subscriptions/subscription.js',
    'resources/assets/js/subscriptions/free-subscription.js',
    'resources/assets/js/subscriptions/user-free-subscription.js',
    'resources/assets/js/subscriptions/payment-message.js',
    'resources/assets/js/settings/settings.js',
    'resources/assets/js/settings/user_settings.js',
    'resources/assets/js/google_calendar/google_calendar.js',
    'resources/assets/js/sidebar-menu-search/sidebar-menu-search.js',
    'resources/assets/js/currencies/currencies.js',
], 'public/assets/js/pages.js')

// front page JS
mix.js([
    'resources/assets/js/custom/helper.js',
    'resources/assets/js/custom/custom.js',
    'resources/assets/js/custom/phone-number-country-code.js',
    'resources/assets/js/slot_calendar/slot-calendar.js',
    'resources/assets/js/event_schedules/event-slot-schedule.js',
    'resources/assets/js/custom-livewire-calendar/custom-livewire-calendar.js',
], 'public/assets/js/front-pages.js')

//stepper JS code
mix.js('resources/assets/js/custom/custom.js',
    'public/assets/js/custom/custom.js')
mix.js('resources/assets/js/custom/helper.js',
    'public/assets/js/custom/helper.js')

// third party JS
mix.scripts([
    'public/front/js/bootstrap.bundle.min.js',
    'public/front/js/jquery.min.js',
    'node_modules/toastr/build/toastr.min.js',
    'node_modules/slick-carousel/slick/slick.min.js',
], 'public/assets/js/front-third-party.js').version()

mix.js('resources/assets/js/front/customer-on-board.js',
    'public/assets/js/front/customer-on-board.js').version()

// front JS code
mix.js([
    'resources/assets/js/turbo.js',
    'resources/assets/js/custom/helper.js',
    'resources/assets/js/subscribers/create.js',
    'resources/assets/js/front/contact-us.js',
    'resources/assets/js/front/front-custom.js',
], 'public/assets/js/front-page.js')

mix.js('resources/assets/js/schedule_events/check-otp.js',
    'public/assets/js/schedule_events/check-otp.js')

// evo calendar JS code
mix.copy('node_modules/evo-calendar/evo-calendar/js/evo-calendar.js',
    'public/assets/js/evo-calendar.js')

// front CSS code
mix.sass('resources/assets/css/front/custom.scss',
    'public/assets/css/front/custom.css').version()

mix.js('resources/assets/js/livewire-turbolinks.js',
    'public/assets/js/livewire-turbolinks.js')
