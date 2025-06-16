<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PizzaTypeRequest;
use App\Http\Resources\PizzaTypeResource;
use App\Services\PizzaTypeService;

class PizzaTypeController extends Controller
{
    public function __construct(protected PizzaTypeService $service) {}

    public function index()
    {
        return PizzaTypeResource::collection($this->service->all());
    }

    public function store(PizzaTypeRequest $request)
    {
        $pizzaType = $this->service->create($request->validated());
        return new PizzaTypeResource($pizzaType);
    }

    public function show(string $id)
    {
        return new PizzaTypeResource($this->service->show($id));
    }

    public function update(PizzaTypeRequest $request, string $id)
    {
        $pizzaType = $this->service->update($id, $request->validated());
        return new PizzaTypeResource($pizzaType);
    }

    public function destroy(string $id)
    {
        $this->service->delete($id);
        return response()->noContent();
    }
}

