<?php

namespace App\Services;

use App\Models\Order;
use Spatie\QueryBuilder\QueryBuilder;

class OrderService
{
    public function all()
    {
        return QueryBuilder::for(Order::class)
            ->allowedFilters(['order_id', 'date'])
            ->allowedSorts(['date', 'time'])
            ->with('orderDetails.pizza')
            ->paginate(20);
    }

    public function create(array $data)
    {
        return Order::create($data);
    }

    public function show(string $id)
    {
        return Order::with('orderDetails.pizza')->findOrFail($id);
    }

    public function update(string $id, array $data)
    {
        $order = Order::findOrFail($id);
        $order->update($data);
        return $order;
    }

    public function delete(string $id): void
    {
        Order::destroy($id);
    }
}
