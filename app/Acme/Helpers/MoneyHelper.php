<?php

namespace App\Acme\Helpers;

use Illuminate\Support\Facades\Request;

class MoneyHelper
{
    /**
     * @return array|\Illuminate\Config\Repository|mixed|string|null
     */
    public static function getCurrentCurrency()
    {
        $request = Request::instance();
        $currency = ($request->hasHeader("x-currency")) ? $request->header('x-currency') : config("currency.default");

        return $currency;
    }

    /**
     * @param $value
     * @return float|int
     */
    public static function convertDollarToCents($value)
    {
        return $value*100;
    }

    public static function convertCentsToDollar($value)
    {
        return round($value/100, 2);
    }
}