<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'required|mimes:jpeg,jpg,png,gif',
            'type' => 'required|integer|min:1|max:4'
        ];
    }
}
