<?php

namespace App\Acme;

interface DeliveryInterface
{
    public function calculate(Cart $cart);
}