<?php

namespace App\Http\Requests\Api\User;
use App\Http\Requests\Api\MainRequest;


class BuyPackageRequest extends MainRequest
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
            'package_id' => 'required|exists:packages,id'
        ];
    }
}
