<?php

namespace App\Acme;

class Pickup implements DeliveryInterface
{
    public function calculate(Cart $cart)
    {
        return 0;
    }
}