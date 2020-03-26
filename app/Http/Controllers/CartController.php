<?php

namespace App\Http\Controllers;

use App\Acme\DeliveryFactory;
use App\Acme\Helpers\MoneyHelper;
use App\Http\Requests\CartCheckoutRequest;
use App\Http\Requests\CartItemsRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Acme\Cart;

class CartController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(CartItemsRequest $request)
    {
        $cart = new Cart($request, $this->currency);
        $cart->setInCents(false);

        return response()->json($cart->getContent(), 200);
    }

    /**
     * @param CartCheckoutRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkout(CartCheckoutRequest $request)
    {
        $user = auth()->user();
        $cart = new Cart($request, $this->currency);
        $cart->setInCents(true);
        $cartContent = $cart->getContent();
        $delivery_id  = $request->get('delivery');

        $order = new Order();
        $order->user_id = $user!==null ? $user->id : null;
        $order->name = $request->get('name');
        $order->email = $request->get('email');
        $order->phone = $request->get('phone');
        $order->address = $request->get('address');
        $order->delivery = $request->get('delivery');
        $order->payment = $request->get('payment');
        $order->currency = $this->currency;

        $delivery = DeliveryFactory::factory($delivery_id);
        $delivery_price = round(currency($delivery->calculate($cart), config('currency.default'), $this->currency, false));
        $order->delivery_price = $delivery_price;
        $order->total_price = round($delivery_price + $cartContent["total"]);

        try {
            $order->save();

            $items = [];
            foreach($cartContent["items"] as $cartItem)
            {
                $item = new OrderItem();
                $item->product_id = $cartItem["id"];
                $item->quantity = $cartItem["quantity"];
                $item->price = $cartItem["price"];

                $items[] = $item;
            }

            $order->items()->saveMany($items);

            if($user) {
                $user->phone = $request->get('phone');
                $user->address = $request->get('address');
                $user->save();
            }

            return response()->json(["id" => $order->id], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->error($ex->getMessage(), 422);
        }
    }
}