<?php

namespace App\Acme;

use App\Acme\Helpers\MoneyHelper;
use App\Models\Product;
use Illuminate\Http\Request;

class Cart
{
    protected $currency;
    protected $request;
    protected $parsedItems;
    protected $in_cents = false;

    /**
     * Cart constructor.
     * @param $currency
     * @param Request $request
     */
    public function __construct(Request $request, $currency)
    {
        $this->request = $request;
        $this->setCurrency($currency);
        $this->parseRequestItems();
    }

    /**
     * @param Request $request
     */
    public function parseRequestItems()
    {
        $arItems = [];
        $items = [];

        if($this->request->has('items')) {
            $items = $this->request->get('items');
        }

        if(count($items)>0) {
            foreach ($items as $item) {
                $id = intval($item['id']);
                $q = intval($item['quantity']);

                if ($id > 0 && $q > 0) {
                    $arItems[$id] = $q;
                }
            }

            unset($items);
        }

        $this->parsedItems = $arItems;
    }

    /**
     * @param $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @param bool $in_cents
     */
    public function setInCents(bool $in_cents)
    {
        $this->in_cents = $in_cents;
    }

    /**
     * @return array
     */
    public function getContent()
    {
        $currency = $this->currency;
        $arItems= $this->parsedItems;
        $cartItems = [];
        $total = 0;

        if(count($arItems)>0) {
            $ids = array_keys($arItems);
            $products = Product::whereIn("id", $ids)->get();

            if(count($products)>0) {
                foreach($products as $product) {

                    $price = $product->price;
                    $quantity = intval($arItems[$product->id]);

                    if(!$this->in_cents) {
                        $price = MoneyHelper::convertCentsToDollar($price);
                    }else{
                        $price = round($price);
                    }

                    $sum = $quantity*$price;
                    $sum_format =  currency($sum, $currency, $currency);
                    $price_format = currency($price, $currency, $currency);

                    $total += $sum;

                    $cartItems[] = [
                        'id' => $product->id,
                        'title' => $product->title,
                        'image' => asset("storage/images/". $product->image),
                        'description' => $product->description,
                        'quantity' => $quantity,
                        'price' => $price,
                        'price_format' => $price_format,
                        'sum' => $sum,
                        'sum_format' => $sum_format
                    ];
                }
            }
        }

        return [
            'items' => $cartItems,
            'total' => $total,
            "total_format" => currency($total, $currency, $currency),
        ];
    }

    /**
     * @return false|float
     */
    public function total()
    {
        return $this->getContent()["total"];
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->getContent()["items"]);
    }
}