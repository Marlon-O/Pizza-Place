<?php

namespace App\Services;

use App\Models\OrderDetail;
use Spatie\QueryBuilder\QueryBuilder;

class OrderDetailService
{
    public function all()
    {
        return QueryBuilder::for(OrderDetail::class)
            ->allowedFilters(['order_id', 'pizza_id'])
            ->allowedSorts(['quantity'])
            ->with(['order', 'pizza'])
            ->paginate(20);
    }

    public function create(array $data)
    {
        return OrderDetail::create($data);
    }

    public function show(string $id)
    {
        return OrderDetail::with(['order', 'pizza'])->findOrFail($id);
    }

    public function update(string $id, array $data)
    {
        $detail = OrderDetail::findOrFail($id);
        $detail->update($data);
        return $detail;
    }

    public function delete(string $id): void
    {
        OrderDetail::destroy($id);
    }
}
