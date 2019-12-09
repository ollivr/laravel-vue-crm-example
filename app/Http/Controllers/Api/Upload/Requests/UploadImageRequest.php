<?php

namespace App\Http\Controllers\Api\Upload\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws
     */
    public function rules()
    {
        return  [
            'image' => 'required|image',
        ];
    }
}