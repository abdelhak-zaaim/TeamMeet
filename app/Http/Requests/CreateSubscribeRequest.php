<?php

namespace App\Http\Requests;

use App\Models\Subscribe;
use Illuminate\Foundation\Http\FormRequest;

class CreateSubscribeRequest extends FormRequest
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
        return Subscribe::$rules;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function messages(): array
    {
        return [
            'email.unique' => __('messages.subscription_plan.email_already_subscribed'),
        ];
    }
}
