
   <div class="container-fluid">
        @include('flash::message')
        <div class="d-flex flex-column">
            <div class="align-items-center mb-3">
                <div class="row">
                    <div class="col-xl-4 col-md-6 widget">
                        <a href="{{ route('users.index') }}"
                           class="text-decoration-none">
                            <div class="bg-primary shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                                <div class="bg-cyan-300 widget-icon rounded-10 d-flex align-items-center justify-content-center me-2">
                                    <i class="fa-solid fa-money-check fs-1-xl text-white"></i>
                                </div>
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-bolder text-white">{{$totalUsers}}</h2>
                                    <h3 class="mb-0 fs-4 fw-light">{{__('messages.user_dashboard.total_users')}}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-md-6 widget">
                        <div class="bg-warning shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                            <div class="bg-yellow-300 widget-icon rounded-10 d-flex align-items-center justify-content-center me-2">
                                <i class="fa-solid fa-money-check fs-1-xl text-white"></i>
                            </div>
                            <div class="text-end text-white">
                                <h2 class="fs-1-xxl fw-bolder text-white">{{$totalScheduledEvents}}</h2>
                                <h3 class="mb-0 fs-4 fw-light">{{__('messages.user_dashboard.total_scheduled_events')}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 widget">
                        <div class="bg-info shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                            <div class="bg-blue-300 widget-icon rounded-10 d-flex align-items-center justify-content-center me-2">
                                <i class="fa-solid fa-money-check fs-1-xl text-white"></i>
                            </div>
                            <div class="text-end text-white">
                                <h2 class="fs-1-xxl fw-bolder text-white">{{ $totalActiveEvents}}</h2>
                                <h3 class="mb-0 fs-4 fw-light">{{__('messages.user_dashboard.active_events')}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
