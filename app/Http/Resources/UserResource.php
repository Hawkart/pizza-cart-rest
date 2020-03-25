<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Storage;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->when(Auth::user() && Auth::user()->id==$this->id, $this->email),
            'phone' => $this->phone,
            'address' => $this->address,

            'carts' => CartResource::collection($this->whenLoaded('carts')),
            'orders' => OrderResource::collection($this->whenLoaded('orders'))
        ];
    }
}