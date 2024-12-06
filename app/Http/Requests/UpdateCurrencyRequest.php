<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrencyRequest extends FormRequest
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
        $rules['currency_name'] = 'required|unique:currencies,currency_name,'.$this->route('currency')->id;
        $rules['currency_icon'] = 'required';
        $rules['currency_code'] = 'required|min:3|max:3';

        return $rules;
    }
}
