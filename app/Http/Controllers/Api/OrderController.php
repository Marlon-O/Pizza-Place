<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $service) {}

    public function index()
    {
        return OrderResource::collection($this->service->all());
    }

    public function store(OrderRequest $request)
    {
        $order = $this->service->create($request->validated());
        return new OrderResource($order);
    }

    public function show(string $id)
    {
        return new OrderResource($this->service->show($id));
    }

    public function update(OrderRequest $request, string $id)
    {
        $order = $this->service->update($id, $request->validated());
        return new OrderResource($order);
    }

    public function destroy(string $id)
    {
        $this->service->delete($id);
        return response()->noContent();
    }

    public function addDetail(Request $request, Order $order)
    {
        $validated = $request->validate([
            'pizza_id' => ['required', 'exists:pizzas,pizza_id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $order->orderDetails()->create($validated);

        return response()->json(['message' => 'Order detail added successfully.']);
    }
}
