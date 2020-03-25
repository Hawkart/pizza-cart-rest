<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('register', 'AuthController@signup');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

Route::apiResource('categories', 'CategoryController')->only(["index", 'show']);
Route::apiResource('products', 'ProductController')->only(["index", 'show']);
Route::apiResource('carts', 'CartController')->except(['update', 'index']);
Route::apiResource('orders', 'OrderController')->except(['update', 'destroy','store'])->middleware('auth:api');


Route::get("deliveries", "DeliveryController@index");
Route::post("deliveries/{delivery_id}/calculate", "DeliveryController@calculate");
Route::get("payments", "PaymentController@index");
Route::post('cart', 'CartController@show');
Route::post('cart/checkout', 'CartController@checkout');