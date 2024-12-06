<div class="overflow-hidden">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item mb-3" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#eventDetail" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">{{ __('messages.event.event_detail') }}
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                    data-bs-target="#scheduledEvent" type="button" role="tab"
                    aria-controls="pills-profile" aria-selected="false">{{__('messages.schedule_events')}}
            </button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="eventDetail" role="tabpanel">
            <div class="card">
                <div>
                    <div class="card-body">
                        <div class="row mb-7">
                            <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.event.event_name')  }}</label>
                            <div class="col-lg-8">
                                <span class="fs-4 text-gray-800">{{ $event->name }}</span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.event.location') }}</label>
                            <div class="col-lg-8 fv-row">
                                <span class="fs-4 text-gray-800">{{ \App\Models\Event::LOCATION_ARRAY[$event->event_location] }}</span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.event.event_landing_page') }}</label>
                            <div class="col-lg-8">
                                <span class="fs-4 text-gray-800">{{ $event->event_link }}</span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.event.event_type') }}</label>
                            <div class="col-lg-8">
                                @if($event->event_type == \App\Models\Event::FREE)
                                    <span class="badge bg-info">{{ \App\Models\Event::EVENT_TYPE[$event->event_type] }}</span>
                                @else
                                    <span class="badge bg-success">{{ \App\Models\Event::EVENT_TYPE[$event->event_type] }}</span>
                                @endif
                            </div>
                        </div>
                        @if($event->event_type == \App\Models\Event::PAID)
                            <div class="row mb-7">
                                <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.event.payable_amount') }}</label>
                                <div class="col-lg-8">
                                    <span class="fs-4 text-gray-800">{{ getCurrencyIcon() }}  {{ $event->payable_amount }}</span>
                                </div>
                            </div>
                        @endif
                        <div class="row mb-7">
                            <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.event.description') }}</label>
                            <div class="col-lg-8">
                                <span class="fs-4 text-gray-800">{!! !empty($event->description) ? $event->description : __('messages.common.n/a')  !!}</span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.common.created_at') }}</label>
                            <div class="col-lg-8">
                                <span class="fs-4 text-gray-800 " data-bs-toggle="tooltip"
                                      data-bs-placement="right"
                                      title="{{\Carbon\Carbon::parse($event->created_at)->translatedFormat('jS M Y')}}">{{$event->created_at->diffForHumans()}}</span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.common.last_updated') }}</label>
                            <div class="col-lg-8">
                                <span class="fs-4 text-gray-800" data-bs-toggle="tooltip"
                                      data-bs-placement="right"
                                      title="{{\Carbon\Carbon::parse($event->updated_at)->translatedFormat('jS M Y')}}">{{$event->updated_at->diffForHumans()}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="scheduledEvent" role="tabpanel">
            <div class="container-fluid px-0">
                <div class="d-flex flex-column">
                    <livewire:event-scheduled-event-table lazy :eventId="$event->id"/>
                    </div>
                </div>
        </div>
    </div>
</div>
