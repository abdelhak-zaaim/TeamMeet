<div class="col-12">
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" role="tabpanel">
            <div class="card mb-5 mb-xl-10">
                <div class="card-body p-9">
                    <div class="row mb-7">
                        <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.common.name') }}</label>
                        <div class="col-lg-8 fv-row">
                            <span class="fs-4 text-gray-8000">{{ $transaction->scheduleEvent->name }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.user.email') }}</label>
                        <div class="col-lg-8 fv-row">
                            <span class="fs-4 text-gray-800">{{ $transaction->scheduleEvent->email }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.schedule_event.amount') }}</label>
                        <div class="col-lg-8 fv-row">
                            <span class="fs-4 text-gray-800">{{ getCurrencyIcon() }} {{ number_format($transaction->amount) }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.schedule_event.date') }}</label>
                        <div class="col-lg-8 fv-row">
                            <span class="fs-4 text-gray-800">{{ \Carbon\Carbon::parse($transaction->created_at)->translatedFormat('jS M, Y h:i A') }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.event.event_name') }}</label>
                        <div class="col-lg-8 fv-row">
                            <span class="fs-4 text-gray-800">{{ $transaction->scheduleEvent->event->name }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.user_dashboard.schedule_date_time') }}</label>
                        <div class="col-lg-8 fv-row">
                            <span class="badge bg-light-info">
                                {{ $transaction->scheduleEvent->schedule_date }} {{ $transaction->scheduleEvent->slot_time }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.transaction.payment_status') }}</label>
                        <div class="col-lg-8 fv-row">
                            <span class="badge bg-light-success">{{ __('messages.transaction.paid') }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fs-4 text-gray-600">{{ __('messages.schedule_event.payment_type') }}</label>
                        <div class="col-lg-8">
                            @if($transaction->type == \App\Models\EventSchedule::STRIPE)
                                <span class="badge bg-light-success">{{ 
  \App\Models\EventSchedule::PAYMENT_METHOD[$transaction->type] }}</span>
                            @else
                                <span class="badge bg-light-primary">{{ \App\Models\EventSchedule::PAYMENT_METHOD[$transaction->type] }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

