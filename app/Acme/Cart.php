<?php

namespace App\Acme;

use App\Models\Product;
use Illuminate\Http\Request;

class Cart
{
    protected $currency;
    protected $request;
    protected $parsedItems;

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
                    $quantity = intval($arItems[$product->id]);
                    $sum = $quantity*$product->price;
                    $total += $sum;

                    $cartItems[] = [
                        'id' => $product->id,
                        'title' => $product->title,
                        'image' => asset("storage/images/". $product->image),
                        'description' => $product->description,
                        'quantity' => $quantity,
                        'price' => round($product->price, 2),
                        'price_format' => currency($product->price, $currency, $currency),
                        'sum' => round($sum, 2),
                        'sum_format' => currency($sum, $currency, $currency)
                    ];
                }
            }
        }

        return [
            'items' => $cartItems,
            'total' => round($total, 2),
            "total_format" => currency($total, $currency, $currency),
        ];
    }

    /**
     * @return false|float
     */
    public function total()
    {
        return round($this->getContent()["total"], 2);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->getContent()["items"]);
    }
}