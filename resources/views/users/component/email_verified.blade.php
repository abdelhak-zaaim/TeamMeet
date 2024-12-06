<label class="ps-0 form-check form-switch form-check-custom form-check-solid form-switch-sm d-flex justify-content-center {{ empty($row->email_verified_at) ? 'cursor-pointer checked' : '' }}">
    <input name="email_verify" data-id="{{$row->id}}"
           class="form-check-input user-email-verify cursor-pointer {{ empty($row->email_verified_at) ? 'cursor-pointer checked' : '' }}"
           type="checkbox" {{ !empty($row->email_verified_at) ? 'disabled checked' : '' }}>
    <span class="switch-slider text-ce" data-checked="&#x2713;" data-unchecked="&#x2715;"></span>
</label>
