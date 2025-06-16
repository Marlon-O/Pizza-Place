<?php

use App\Http\Resources\OrderResource;
use App\Http\Resources\PizzaResource;
use App\Models\Order;
use App\Models\Pizza;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->middleware('guest')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('inventory', function () {
        return Inertia::render('inventory/Index');
    })->name('inventory');

    Route::get('orders', function () {
        return Inertia::render('order/Index');
    })->name('orders');

    Route::get('orders/{order}', function (Order $order) {
        $order->load('orderDetails.pizza.pizzaType');

        return Inertia::render('order/Show', [
            'order' => new OrderResource($order),
            'pizzas' => PizzaResource::collection(Pizza::with('pizzaType')->get()),
        ]);
    })->name('orders.show');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
