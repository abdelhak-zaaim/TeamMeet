<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
        return User::$rules;
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'profile.max' => __('messages.placeholder.profile_size_should_be_less_than_2_mb'),
        ];
    }
}
