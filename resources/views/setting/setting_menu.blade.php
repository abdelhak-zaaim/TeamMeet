@include('layouts.errors')
@include('flash::message')
<div>
    <ul class="nav nav-tabs mb-5 pb-1 overflow-auto flex-nowrap text-nowrap" id="myTab" role="tablist">
        <li class="nav-item position-relative me-7 mb-3">
            <a class="nav-link me-0 p-0 {{ (isset($sectionName) && $sectionName == 'general') ? 'active' : ''}}"    href="{{ route('settings.index',['section' => 'general']) }}">{{ __('messages.setting.general') }}</a>
        </li>
        <li class="nav-item position-relative me-7 mb-3" role="presentation">
            <a class="nav-link me-0 p-0 {{ (isset($sectionName) && $sectionName == 'credentials') ? 'active' : ''}}"
               href="{{ route('settings.index',['section' => 'credentials']) }}">{{__('messages.setting.credentials') }}</a>
        </li>
    </ul>
</div>
