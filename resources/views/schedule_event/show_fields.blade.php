<div class="col-12">
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="patientOverview" role="tabpanel">
            <div class="row mb-7">
                <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.common.name')  }}</label>
                <div class="col-lg-8">
                    <span class="fs-4 text-gray-800">{{ $eventSchedule->name }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.user.email') }}</label>
                <div class="col-lg-8 fv-row">
                                <span class="fs-4 text-gray-800"><a
                                            href="mailto:{{ $eventSchedule->email }}"
                                            class="text-decoration-none">{{ $eventSchedule->email }}</a></span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.schedule_event.scheduled_date') }}</label>
                <div class="col-lg-8 fv-row">
                    <span class="fs-4 text-gray-800">{{ $eventSchedule->schedule_date }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.event.event_name') }}</label>
                            <div class="col-lg-8">
                                <span class="fs-4 text-gray-800">{{ $eventSchedule->event->name }}</span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.event.event_type') }}</label>
                            <div class="col-lg-8">
                                <span class="badge bg-light-{{getBadgeEventTypeColors($eventSchedule->event->event_type)}} ">{{ \App\Models\Event::EVENT_TYPE[$eventSchedule->event->event_type] }}</span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.event.description') }}</label>
                            <div class="col-lg-8">
                                <span class="fs-4 text-gray-800">{!! $eventSchedule->description ?? 'N/A'  !!}</span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.schedule_event.scheduled_time') }}</label>
                            <div class="col-lg-8">
                                <span class="fs-4 text-gray-800">{{ $eventSchedule->slot_time }}</span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.schedule_event.status') }}</label>
                            <div class="col-lg-8">
                                <span class="badge bg-light-{{getBadgeColors($eventSchedule->status)}} ">{{ \App\Models\EventSchedule::STATUS[$eventSchedule->status] }}</span>
                            </div>
                        </div>
                        @if($eventSchedule->payment_type && $eventSchedule->event->event_type == \App\Models\Event::PAID)
                            <div class="row mb-7">
                                <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.schedule_event.payment_type') }}</label>
                                <div class="col-lg-8">
                                    @if($eventSchedule->payment_type == \App\Models\EventSchedule::STRIPE)
                                        <span class="badge bg-light-success">{{
      \App\Models\EventSchedule::PAYMENT_METHOD[$eventSchedule->payment_type] }}</span>
                                    @elseif ($eventSchedule->payment_type == \App\Models\EventSchedule::PAYPAL)
                                        <span class="badge bg-light-primary">{{ \App\Models\EventSchedule::PAYMENT_METHOD[$eventSchedule->payment_type] }}</span>
                                    @elseif ($eventSchedule->payment_type == \App\Models\EventSchedule::PAYSTACK)
                                        <span class="badge bg-light-primary">{{ \App\Models\EventSchedule::PAYMENT_METHOD[$eventSchedule->payment_type] }}</span>
                                    @elseif ($eventSchedule->payment_type == \App\Models\EventSchedule::RAZORPAY)
                                        <span class="badge bg-light-primary">{{ \App\Models\EventSchedule::PAYMENT_METHOD[$eventSchedule->payment_type] }}</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        <div class="row mb-7">
                            <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.schedule_event.cancel_reason') }}</label>
                            <div class="col-lg-8">
                                <span class="fs-4 text-gray-800">{{ $eventSchedule->cancel_reason ?? 'N/A' }}</span>
                            </div>
                        </div>
            <div class="row mb-7">
                <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.common.created_at') }}</label>
                <div class="col-lg-8">
                                <span class="fs-4 text-gray-800 " data-bs-toggle="tooltip"
                                      data-bs-placement="right"
                                      title="{{\Carbon\Carbon::parse($eventSchedule->created_at)->translatedFormat('jS M Y')}}">{{$eventSchedule->created_at->diffForHumans()}}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.common.last_updated') }}</label>
                <div class="col-lg-8">
                                <span class="fs-4 text-gray-800" data-bs-toggle="tooltip"
                                      data-bs-placement="right"
                                      title="{{\Carbon\Carbon::parse($eventSchedule->updated_at)->translatedFormat('jS M Y')}}">{{$eventSchedule->updated_at->diffForHumans()}}</span>
                </div>
            </div>
            @if($eventSchedule->status == \App\Models\EventSchedule::HOLD)
                <div class="row mb-7">
                    <label class="col-lg-4 fs-4 text-gray-600"></label>
                    <div class="col-lg-8">
                        <a href="{{ route('remove.hold.status.user', $eventSchedule->id) }}"
                           class="btn btn-primary">{{ __('messages.remove_hold_status') }}</a>
                    </div>
                </div>
                        @endif
                    </div>
                </div>
            </div>
