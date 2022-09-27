<?php

namespace App\Http\Requests\Sale;

use Illuminate\Foundation\Http\FormRequest;

class CreateSaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_id' => 'required',
            'subscription_id' => 'required',
            'validity_visits' => 'required',
            'price' => 'required',
            'user_id' => 'required',
            'payment_type' => 'required',
            'trainer_id' => 'sometimes',
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'user_id' => auth()->id()
        ]);
    }
}
