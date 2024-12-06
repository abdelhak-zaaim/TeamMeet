<div class="d-flex flex-column">
    <div class="align-items-center mb-3">
        @if($activeEventsCount == 0)
            <div class="col-xxl-12">
                <div class="card card-xxl-stretch mb-5 mb-xxl-8">
                    <div class="card-body py-3">
                        <div class="overflow-auto pb-5 pt-5">
                            <div class="d-sm-flex align-items-center justify-content-between rounded border-primary border border-dashed min-w-lg-600px flex-shrink-0 p-6">
                                <div class="d-flex mb-3 mb-md-0">
                                    <i class="fas fa-calendar-alt fs-1 me-2"></i>
                                    <h4>{{ __('messages.user_dashboard.create_your_first_event') }}</h4>
                                </div>
                                <a href="{{ route('events.create') }}"
                                   class="btn btn-primary" data-turbo="false">{{ __('messages.event.add_event') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                    <a href="{{ route('scheduled-events.index', ['today' => 1]) }}"
                       class="text-decoration-none">
                        <div class="bg-primary shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                            <div class="bg-cyan-300 widget-icon rounded-10 d-flex align-items-center justify-content-center me-2">
                                <i class="fa-solid fa-money-check fs-1-xl text-white"></i>
                            </div>
                            <div class="text-end text-white">
                                <h2 class="fs-1-xxl fw-bolder text-white">{{ $todayScheduledEvents->count() }}</h2>
                                <h3 class="mb-0 fs-4 fw-light">{{ __('messages.user_dashboard.todays_scheduled_events') }}</h3>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                    <a href="{{ route('scheduled-events.index', ['today' => 0]) }}"
                       class="text-decoration-none">
                        <div class="bg-dark shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                            <div class="bg-gray-700 widget-icon rounded-10 d-flex align-items-center justify-content-center me-2">
                                <i class="fa-solid fa-money-check fs-1-xl text-white"></i>
                            </div>
                            <div class="text-end text-white">
                                <h2 class="fs-1-xxl fw-bolder text-white">{{ $upcomingScheduledEvents->count() }}</h2>
                                <h3 class="mb-0 fs-4 fw-light">{{__('messages.user_dashboard.upcoming_scheduled_events')}}</h3>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                    <a href="{{ route('events.index') }}"
                       class="text-decoration-none">
                        <div class="bg-warning shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                            <div class="bg-yellow-300 widget-icon rounded-10 d-flex align-items-center justify-content-center me-2">
                                <i class="fa-solid fa-money-check fs-1-xl text-white"></i>
                            </div>
                            <div class="text-end text-white">
                                <h2 class="fs-1-xxl fw-bolder text-white">{{ $activeEventsCount }}</h2>
                                <h3 class="mb-0 fs-4 fw-light">{{__('messages.user_dashboard.active_events')}}</h3>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                    <a href="{{ route('schedules.index') }}"
                       class="text-decoration-none">
                        <div class="bg-info shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                            <div class="bg-blue-300 widget-icon rounded-10 d-flex align-items-center justify-content-center me-2">
                                <i class="fa-solid fa-money-check fs-1-xl text-white"></i>
                            </div>
                            <div class="text-end text-white">
                                <h2 class="fs-1-xxl fw-bolder text-white">{{$activeSchedulesCount}}</h2>
                                <h3 class="mb-0 fs-4 fw-light">{{__('messages.user_dashboard.active_schedules')}}</h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-xxl-6">
                    <h3 class="mb-2">{{__('messages.user_dashboard.todays_scheduled_events')}}</h3>
                    <div class="card card-xxl-stretch mb-5 mb-xxl-8">
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table class="table table-striped align-middle">
                                    <thead>
                                    <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="col">{{__('messages.admin_dashboard.name')}}</th>
                                        <th class="col">{{__('messages.event.event_name')}}</th>
                                        <th class="col">{{__('messages.schedule_event.scheduled_date')}}</th>
                                        <th class="col">{{__('messages.user_dashboard.schedule_date_time')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-bold">
                                    @forelse($todayScheduledEvents as $value)
                                        <tr>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->event->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($value->schedule_date)->format('Y-m-d') }}</td>
                                            <td>
                                                <span class="badge bg-light-info">{{ $value->slot_time }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"
                                                class="text-center">{{ __('messages.user_dashboard.no_schedules_events_yet') }}
                                                ...
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6">
                    <h3 class="mb-2">{{__('messages.user_dashboard.upcoming_scheduled_events')}}</h3>
                    <div class="card card-xxl-stretch mb-5 mb-xxl-8">
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table class="table table-striped align-middle">
                                    <thead>
                                    <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="col">{{__('messages.admin_dashboard.name')}}</th>
                                        <th class="col">{{__('messages.event.event_name')}}</th>
                                        <th class="col">{{__('messages.schedule_event.scheduled_date')}}</th>
                                        <th class="col">{{__('messages.user_dashboard.schedule_date_time')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-bold">
                                    @forelse($upcomingScheduledEvents as $value)
                                        <tr>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->event->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($value->schedule_date)->format('Y-m-d') }}</td>
                                            <td>
                                                <span class="badge bg-light-info">{{ $value->slot_time }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"
                                                class="text-center">{{ __('messages.user_dashboard.no_schedules_events_yet') }}
                                                ...
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
