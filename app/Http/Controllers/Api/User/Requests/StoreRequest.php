<?php

namespace App\Http\Controllers\Api\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @throws
     */
    public function rules()
    {
        return  [
            'name'                  => 'required|string|min:1|max:255',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|min:6|max:20|confirmed',
            'password_confirmation' => 'required|same:password',
        ];
    }
}