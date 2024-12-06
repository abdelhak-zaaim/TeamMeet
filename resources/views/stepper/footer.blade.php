<footer>
    <div class="container-fluid padding-0">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-6">
                <div class="copyright text-center text-muted">
                    {{ __('messages.all_rights_reserved') }} &copy; {{ date('Y') }} <a href="{{ config('app.url') }}"
                                                                                       class="font-weight-bold ml-1"
                                                                                       target="_blank">{{ getSettingData()['application_name'] }}</a>
                </div>
            </div>
        </div>
    </div>
</footer>
