<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateEventRequest extends FormRequest
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
        return [
            'name' => [
                'required',
                Rule::unique('events')
                    ->where('user_id', getLogInUserId()),
            ],
            'event_location' => 'required',
            'event_link' => 'required|regex:/^[A-Za-z0-9\-]+$/|unique:events,event_link',
            'event_color' => 'required',
            'payable_amount' => 'numeric|gt:0',
        ];
    }
}
