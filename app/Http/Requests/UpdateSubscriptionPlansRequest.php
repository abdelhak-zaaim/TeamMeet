<?php

namespace App\Http\Requests;

use App\Models\SubscriptionPlan;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriptionPlansRequest extends FormRequest
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
        $rules = SubscriptionPlan::$rules;
        $rules['name'] = 'required|max:50|unique:subscription_plans,name,'.$this->route('subscription_plan');

        return $rules;
    }
}
