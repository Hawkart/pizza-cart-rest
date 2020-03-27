<?php

namespace App\Http\Controllers;

use App\Acme\Checkout;
use App\Http\Requests\CartCheckoutRequest;
use App\Http\Requests\CartItemsRequest;
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

        $checkout = new Checkout($cart, $request, $this->currency);
        $checkout->save()->connectItems();

        if($user) {
            $user->phone = $request->get('phone');
            $user->address = $request->get('address');
            $user->save();
        }

        return response()->json(["id" => $checkout->order->id], 200);
    }
}