<?php

namespace App\Http\Resources;

use App\Enums\DeliveryType;
use App\Enums\PaymentType;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'delivery' => DeliveryType::getInstance($this->delivery),
            'delivery_price' => $this->delivery_price,
            'payment' => PaymentType::getInstance($this->payment),
            'total_price' => $this->total_price,
            'currency' => $this->currency,

            'user' => new UserResource($this->whenLoaded('user')),
            'cart' => new OrderResource($this->whenLoaded('cart')),
        ];
    }
}