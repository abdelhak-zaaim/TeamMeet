<?php

namespace App\Http\Requests;

use App\Models\MainReason;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMainReasonRequest extends FormRequest
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
        return MainReason::$rules;
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'image.max' => __('messages.placeholder.image_size_should_be_less_than_2_mb'),
        ];
    }
}
