<?php

namespace App\Http\Controllers;

use App\Acme\Cart;
use App\Acme\DeliveryFactory;
use App\Acme\Helpers\MoneyHelper;
use App\Enums\DeliveryType;
use App\Http\Requests\CartItemsRequest;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Get list of delivery
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(DeliveryType::getInstances(), 200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculate($id, CartItemsRequest $request)
    {
        $currency = $this->currency;
        $cart = new Cart($request, $currency);
        $cart->setInCents(true);
        $delivery = DeliveryFactory::factory($id);
        $price = $delivery->calculate($cart);

        return response()->json([
            "price" =>  MoneyHelper::convertCentsToDollarWithCurrency($price, config('currency.default'), $currency, false),
            "price_format" => MoneyHelper::convertCentsToDollarWithCurrency($price, config('currency.default'), $currency)
        ], 200);
    }
}