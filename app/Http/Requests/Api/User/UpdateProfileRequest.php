<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            "name" => "required",
            "email" => "required|unique:users,email," . auth()->user()->id . ",id,deleted_at,NULL",
            "phone" => "required|numeric|regex:/(01)[0-9]{9}/|unique:users,phone," . auth()->user()->id . ",id,deleted_at,NULL",
            "image" => ""
        ];
    }
}
