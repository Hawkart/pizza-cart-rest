<?php

namespace App\Acme;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class Checkout
{
    protected $currency;
    protected $request;
    protected $cart;
    protected $cart_content;
    public $order;

    /**
     * Checkout constructor.
     * @param Cart $cart
     * @param Request $request
     * @param $currency
     */
    public function __construct(Cart $cart, Request $request, $currency)
    {
        $this->request = $request;
        $this->cart = $cart;
        $this->currency = $currency;
        $this->cart_content = $this->cart->getContent();
    }

    /**
     * @return $this
     */
    public function save()
    {
        $user = auth()->user();
        $delivery_id  = $this->request->get('delivery');

        try {
            $order = new Order();
            $order->user_id = $user!==null ? $user->id : null;
            $order->name = $this->request->get('name');
            $order->email = $this->request->get('email');
            $order->phone = $this->request->get('phone');
            $order->address = $this->request->get('address');
            $order->delivery = $this->request->get('delivery');
            $order->payment = $this->request->get('payment');
            $order->currency = $this->currency;

            $delivery = DeliveryFactory::factory($delivery_id);
            $delivery_price = round(currency($delivery->calculate($this->cart), config('currency.default'), $this->currency, false));
            $order->delivery_price = $delivery_price;
            $order->total_price = round($delivery_price + $this->cart_content["total"]);
            $order->save();

            $this->order = $order;

            return $this;
        } catch(\Exception $e) {
            abort(response()->json(['message' => $e->getMessage()], 400));
        }
    }

    /**
     * Add items of the cart to order
     */
    public function connectItems()
    {
        try {
            $items = [];
            foreach($this->cart_content["items"] as $cartItem) {
                $item = new OrderItem();
                $item->product_id = $cartItem["id"];
                $item->quantity = $cartItem["quantity"];
                $item->price = $cartItem["price"];

                $items[] = $item;
            }

            $this->order->items()->saveMany($items);
        } catch(\Exception $e) {
            abort(response()->json(['message' => $e->getMessage()], 400));
        }
    }
}