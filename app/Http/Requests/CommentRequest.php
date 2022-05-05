<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;


class CommentRequest extends FormRequest
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
            "commentInfo.user_id" => ["required", "integer", "exists:App\Models\User,id"],
            "commentInfo.comment" => ["required", "string"],
            "commentInfo.comment_date" => ["required", "date"]
        ];
    }

    public function messages()
    {
        return [
            'commentInfo.user_id.int' => 'user_id should be int'
        ];
    }
}
