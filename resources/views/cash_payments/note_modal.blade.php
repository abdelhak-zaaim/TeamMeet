<div class="modal fade" id="cashPaymentNoteModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog custom-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{ __('messages.cash_payment.cash_payment_note') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-5">
                   <p class="cash-payment-note text-wrap"></p>
                </div>
            </div>
            {{ Form::close()}}
        </div>
    </div>
</div>
