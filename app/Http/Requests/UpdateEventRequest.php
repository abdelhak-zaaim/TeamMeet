<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'name' => [
                'required',
                Rule::unique('events')
                    ->ignore($this->route('event')->id)
                    ->where('user_id', getLogInUserId()),
            ],
            'event_location' => 'required',
            'event_link' => 'required|regex:/^[A-Za-z0-9\-]+$/|unique:events,event_link,'.$this->route('event')->id,
            'event_color' => 'required',
            'payable_amount' => 'numeric|gt:0',
            'schedule_days' => 'min:1',
        ];

        return $rules;
    }
}
