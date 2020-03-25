<?php

namespace App\Http\Controllers;

use App\Acme\Helpers\MoneyHelper;
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

        return response()->json($cart->getContent(), 200);
    }

    public function checkout(CartCheckoutRequest $request)
    {

    }
}