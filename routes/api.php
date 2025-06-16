<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderDetailController;
use App\Http\Controllers\Api\PizzaController;
use App\Http\Controllers\Api\PizzaTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('pizza-types', PizzaTypeController::class);
Route::apiResource('pizzas', PizzaController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('order-details', OrderDetailController::class);
Route::post('orders/{order}/details', [OrderController::class, 'addDetail']);