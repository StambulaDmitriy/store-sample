<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name' => ['required','string','min:2','max:255'],
            'vendor_code' => ['required','string','min:2','max:255'],
            'description' => ['required','string','min:2','max:65535'],
            'price' => ['required','numeric'],
            'store_products' => ['required','array'],
            'store_products.*' => ['integer'],

        ];
    }
}
