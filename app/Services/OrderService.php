<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class OrderService
{
    public function all()
    {
        return QueryBuilder::for(Order::class)
            ->allowedFilters(['order_id', 'date'])
            ->allowedSorts(['order_id', 'date', 'time'])
            ->with('orderDetails.pizza')
            ->paginate(20);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $order = Order::create([
                'date' => $data['date'],
                'time' => $data['time'],
            ]);

            foreach ($data['order_details'] as $detail) {
                $order->orderDetails()->create([
                    'pizza_id' => $detail['pizza_id'],
                    'quantity' => $detail['quantity'],
                ]);
            }

            return $order->load('orderDetails.pizza.pizzaType');
        });
    }

    public function show(string $id)
    {
        return Order::with('orderDetails.pizza')->findOrFail($id);
    }

    public function update(string $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $order = Order::findOrFail($id);
            $order->update([
                'date' => $data['date'],
                'time' => $data['time'],
            ]);

            $order->orderDetails()->delete();

            foreach ($data['order_details'] as $detail) {
                $order->orderDetails()->create([
                    'pizza_id' => $detail['pizza_id'],
                    'quantity' => $detail['quantity'],
                ]);
            }

            return $order->load('orderDetails.pizza.pizzaType');
        });
    }

    public function delete(string $id): void
    {
        Order::destroy($id);
    }
}
