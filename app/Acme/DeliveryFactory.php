<?php
namespace App\Acme;

use App\Enums\DeliveryType;

final class DeliveryFactory
{
    public static function factory(string $type): DeliveryInterface
    {
        if ($type == DeliveryType::Delivery) {
            return new Delivery();
        } else{
            return new Pickup();
        }
    }
}