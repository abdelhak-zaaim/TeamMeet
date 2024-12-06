<footer class="border-top w-100 py-4 mt-7">
    <div class="d-flex justify-content-between align-items-center fs-6 text-gray-600">
        <div>
            @lang('messages.all_rights_reserved') ©{{ \Carbon\Carbon::now()->year }} <a href="#"
                                                                                        class="text-decoration-none">{{getSettingData()['application_name']}}</a>
        </div>
        @if(config('app.show_version'))
            <div>v{{ version() }}</div>
        @endif
    </div>
</footer>
