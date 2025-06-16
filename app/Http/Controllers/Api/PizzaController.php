<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PizzaRequest;
use App\Http\Resources\PizzaResource;
use App\Services\PizzaService;

class PizzaController extends Controller
{
    public function __construct(protected PizzaService $service) {}

    public function index()
    {
        return PizzaResource::collection($this->service->all());
    }

    public function store(PizzaRequest $request)
    {
        $pizza = $this->service->create($request->validated());
        return new PizzaResource($pizza);
    }

    public function show(string $id)
    {
        return new PizzaResource($this->service->show($id));
    }

    public function update(PizzaRequest $request, string $id)
    {
        $pizza = $this->service->update($id, $request->validated());
        return new PizzaResource($pizza);
    }

    public function destroy(string $id)
    {
        $this->service->delete($id);
        return response()->noContent();
    }
}

