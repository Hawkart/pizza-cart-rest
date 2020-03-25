<?php

namespace App\Http\Controllers;

use App\Enums\PaymentType;

class PaymentController extends Controller
{
    /**
     * Get list
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(PaymentType::getInstances(), 200);
    }
}