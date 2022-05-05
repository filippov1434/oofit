<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;


class ApplicationRequest extends FormRequest
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
            "applicationInfo.user_id" => ["required", "integer", "exists:App\Models\User,id"],
            "applicationInfo.product_id" => ["required", "integer", "exists:App\Models\Product,id"],
            "applicationInfo.app_date" => ["required", "date"]
        ];
    }

    public function messages()
    {
        return [
            'applicationInfo.user_id' => 'user_id should be int ;)'
        ];
    }
}
