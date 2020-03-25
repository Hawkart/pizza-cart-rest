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
            'in_stock' => (int) $this->in_stock,
            'price' => round($this->price, 2),
            'currency' => $currency,
            'price_format' => currency($this->price, $currency, $currency),

            'category' => new CategoryResource($this->whenLoaded('category'))
        ];
    }
}