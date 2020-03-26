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

    /**
     * @param $value
     * @return false|float
     */
    public static function convertCentsToDollar($value)
    {
        return round($value/100, 2);
    }

    /**
     * @param $value
     * @param $currency_from
     * @param $currency_to
     * @param bool $format
     * @return float|int|string|\Torann\Currency\Currency
     */
    public static function convertDollarToCentsWithCurrency($value, $currency_from, $currency_to, $format = true)
    {
        $value = self::convertDollarToCents($value);
        $value = currency($value, $currency_from, $currency_to, $format);

        return $value;
    }

    /**
     * @param $value
     * @param $currency_from
     * @param $currency_to
     * @param bool $format
     * @return false|float|string|\Torann\Currency\Currency
     */
    public static function convertCentsToDollarWithCurrency($value, $currency_from, $currency_to, $format = true)
    {
        $value = self::convertCentsToDollar($value);
        $value = currency($value, $currency_from, $currency_to, $format);

        if(!$format)
            $value = round($value, 2);

        return $value;
    }
}