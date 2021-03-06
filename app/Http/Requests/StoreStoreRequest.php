<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoreRequest extends FormRequest
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
            'address' => ['nullable','string','max:255'],
            'schedule' => ['nullable','string','max:255'],
            'phone' => ['nullable','string','max:255'],
            'coordinate_lat' => ['required','numeric'],
            'coordinate_long' => ['required','numeric'],
        ];
    }
}
