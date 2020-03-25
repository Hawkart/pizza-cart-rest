<?php

namespace App\Acme;

class Delivery implements DeliveryInterface
{
    /**
     * @param Cart $cart
     * @return int
     */
    public function calculate(Cart $cart)
    {
        if($cart->total()>1000) {
            return 200;
        }else{
            return 500;
        }
    }
}