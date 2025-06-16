<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderDetailRequest;
use App\Http\Resources\OrderDetailResource;
use App\Services\OrderDetailService;

class OrderDetailController extends Controller
{
    public function __construct(protected OrderDetailService $service) {}

    public function index()
    {
        return OrderDetailResource::collection($this->service->all());
    }

    public function store(OrderDetailRequest $request)
    {
        $detail = $this->service->create($request->validated());
        return new OrderDetailResource($detail);
    }

    public function show(string $id)
    {
        return new OrderDetailResource($this->service->show($id));
    }

    public function update(OrderDetailRequest $request, string $id)
    {
        $detail = $this->service->update($id, $request->validated());
        return new OrderDetailResource($detail);
    }

    public function destroy(string $id)
    {
        $this->service->delete($id);
        return response()->noContent();
    }
}

