<?php

namespace App\Http\Controllers;

use App\Acme\Helpers\MoneyHelper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $currency;

    /**
     * CartController constructor.
     */
    public function __construct()
    {
        $this->currency = MoneyHelper::getCurrentCurrency();
    }
}
