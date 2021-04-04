<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewProductRequest extends FormRequest
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
            'name'        => 'required|string',
            'image'       => 'image',
            'stock'       => 'required|integer|gte:0',
            'price'       => 'required|numeric|gt:0',
            'supplier_id' => 'required'
        ];
    }
}
