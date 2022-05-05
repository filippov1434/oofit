<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;


class ProductRequest extends FormRequest
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
            "productInfo.name" => ["required", "string", "unique:App\Models\Product,name"],
            "productInfo.status_id" => ["required", "integer", "exists:App\Models\Status,id"],
            "productInfo.category_id" => ["required", "integer", "exists:App\Models\ProductCategory,id"],
            "productInfo.language_id" => ["required", "integer", "exists:App\Models\Language,id"]
        ];
    }

    public function messages()
    {
        return [
            'productInfo.name.string' => 'Name should be string',
            'productInfo.status_id.int' => 'StatusId is wrong - should be an integer'
        ];
    }
}
