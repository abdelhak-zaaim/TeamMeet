<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
            'application_name' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg',
            'favicon' => 'image|mimes:png|dimensions:width=32,height=32',
            'plan_expire_notification' => 'required|max:2',
        ];
    }
}
