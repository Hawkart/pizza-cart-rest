<?php

namespace App\Http\Requests;

use App\Enums\DeliveryType;
use App\Enums\PaymentType;
use BenSampo\Enum\Rules\EnumValue;
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
            'address' => 'required_if:delivery,==,'.DeliveryType::Delivery.'|nullable|string',
            'email' => 'required|email',
            'phone' => 'required|string|min:8',
            'delivery' => 'required|numeric|'.new EnumValue(DeliveryType::class),
            'payment' => 'required|numeric|'.new EnumValue(PaymentType::class),
        ];
    }

    public function messages()
    {
        return [
            "address.required_if" => "The address field is required when delivery has chosen"
        ];
    }
}