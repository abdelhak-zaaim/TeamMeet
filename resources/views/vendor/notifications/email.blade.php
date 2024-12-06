@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang(__('messages.mail.whoops'))
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
{{__('Please click the button below to verify your email address.')}}

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{__('Verify Email Address') }}
@endcomponent
@endisset

{{-- Outro Lines --}}

{{__('If you did not create an account, no further action is required.')}}

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang(__('Regards,'))<br>
{{  getSettingData()['application_name'] }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(__('If you\'re having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser:')) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
