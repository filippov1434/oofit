<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;


class PaymentRequest extends FormRequest
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
            "paymentInfo.user_id" => ["required", "integer", "exists:App\Models\User,id"],
            "paymentInfo.product_id" => ["required", "integer", "exists:App\Models\Product,id"],
            "paymentInfo.payment_date" => ["required", "date"],
            "paymentInfo.price_rub" => ["required", "integer"]
        ];
    }

    public function messages()
    {
        return [
            'paymentInfo.user_id.int' => 'user_id should be int'
        ];
    }
}
