<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
            'lang' => 'required|array|min:1',
            'title' => 'required|array|min:1',
            'description' => 'required|array|min:1',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'color' => 'required',
            'period' => 'required|numeric'
        ];
    }
}
