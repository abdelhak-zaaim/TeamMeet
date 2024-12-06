<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateScheduleRequest extends FormRequest
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
            'schedule_name' => [
                'required',
                Rule::unique('schedules')
                    ->ignore($this->route('schedule')->id)
                    ->where('user_id', getLogInUserId()),
            ],
        ];
    }
}
