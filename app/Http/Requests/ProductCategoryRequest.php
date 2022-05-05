<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;


class ProductCategoryRequest extends FormRequest
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
            "productCategoriesInfo.name" => ["required", "string", "unique:App\Models\ProductCategory,name"],
            "productCategoriesInfo.status_id" => ["required", "integer", "exists:App\Models\Status,id"]
        ];
    }

    public function messages()
    {
        return [
            'productCategoriesInfo.name.string' => 'Name should be string'
        ];
    }
}
