<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email:filter|unique:users,email,'.$this->route('admin')->id,
            'phone_number' => 'required|unique:users,phone_number,'.$this->route('admin')->id,
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
