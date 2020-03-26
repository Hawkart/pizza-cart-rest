<?php

namespace App\Http\Resources;

use App\Acme\Helpers\MoneyHelper;
use App\Enums\DeliveryType;
use App\Enums\PaymentType;
use Carbon\Carbon;
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
            'payment' => PaymentType::getInstance($this->payment),
            'currency' => $this->currency,
            'delivery_price' => MoneyHelper::convertCentsToDollar($this->delivery_price),
            'total_price' => MoneyHelper::convertCentsToDollar($this->total_price),
            'delivery_price_format' => MoneyHelper::convertCentsToDollarWithCurrency($this->delivery_price, $this->currency, $this->currency),
            'total_price_format' => MoneyHelper::convertCentsToDollarWithCurrency($this->total_price, $this->currency, $this->currency),

            'created_at' => Carbon::parse($this->created_at)->format("d.m.Y"),

            'user' => new UserResource($this->whenLoaded('user')),
            'items' => OrderItemResource::collection($this->whenLoaded('items'))
        ];
    }
}