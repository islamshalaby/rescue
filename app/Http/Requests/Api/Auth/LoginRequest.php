<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\MainRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class LoginRequest extends MainRequest
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
            'phone' => 'numeric|required',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            // 'phone.numeric' => translate('numeric', 'validation')
        ];
    }
}
