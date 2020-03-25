<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the User orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $orders = Order::where('email', $user->email)
                        ->orWhere('user_id', $user->id)
                        ->with(['items', 'items.product'])->get();

        return OrderResource::collection($orders);
    }
}