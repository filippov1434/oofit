<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            "userInfo.name" => ["required", "string"],
            "userInfo.email" => ["required","email", "unique:App\Models\User,email"],
            "userInfo.password" => ["required","string"],
            "userInfo.status_id" => ["required", "integer", "exists:App\Models\Status,id"],

            "userSocialInfo.instagram" => ["required", "string", "nullable"],
            "userSocialInfo.telegram" => ["required", "string", "nullable"],
            "userSocialInfo.whatsapp" => ["required", "string", "nullable"],
            "userSocialInfo.vk" => ["required", "string", "nullable"],
        ];
    }

    public function messages()
    {
        return [
            'userInfo.name.string' => 'Name should be string',
            'userInfo.email.email' => 'Invalid email'
        ];
    }
}
