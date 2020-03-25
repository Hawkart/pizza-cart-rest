<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CartCheckoutRequest extends FormRequest {
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
    public function rules(Request $request)
    {
        return [
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'name' => 'required|string|min:3',
            'address' => 'required|string|min:10',  //Todo: required if delivery
            'email' => 'required|email',
            'phone' => 'required|string|min:8',
            'delivery' => 'required|numeric|min:1',
            'payment' => 'required|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}