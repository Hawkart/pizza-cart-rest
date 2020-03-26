<?php

namespace App\Http\Resources;

use App\Acme\Helpers\MoneyHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $currency = MoneyHelper::getCurrentCurrency();

        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => asset("storage/images/". $this->image),
            'price' => MoneyHelper::convertCentsToDollar($this->price),
            'currency' => $currency,
            'price_format' => MoneyHelper::convertCentsToDollarWithCurrency($this->price, $currency, $currency),

            'category' => new CategoryResource($this->whenLoaded('category'))
        ];
    }
}