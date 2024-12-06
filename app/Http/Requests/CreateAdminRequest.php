<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminRequest extends FormRequest
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
            'first_name' => 'required|string|regex:/(^([a-zA-z]+)(\d+)?$)/u',
            'last_name' => 'required|string|regex:/(^([a-zA-z]+)(\d+)?$)/u',
            'email' => 'required|email:filter|unique:users,email',
            'password' => 'required|same:password_confirmation|min:6',
            'phone_number' => 'required|unique:users,phone_number',
            'profile' => 'nullable|mimes:jpeg,png,jpg|max:2000',
        ];
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
