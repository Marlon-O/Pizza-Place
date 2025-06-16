<?php

namespace App\Services;

use App\Models\Pizza;
use Spatie\QueryBuilder\QueryBuilder;

class PizzaService
{
    public function all()
    {
        return QueryBuilder::for(Pizza::class)
            ->allowedFilters(['pizza_id', 'pizza_type_id', 'size'])
            ->allowedSorts(['price', 'size'])
            ->with('pizzaType')
            ->paginate(20);
    }

    public function create(array $data)
    {
        return Pizza::create($data);
    }

    public function show(string $id)
    {
        return Pizza::with('pizzaType')->findOrFail($id);
    }

    public function update(string $id, array $data)
    {
        $pizza = Pizza::findOrFail($id);
        $pizza->update($data);
        return $pizza;
    }

    public function delete(string $id): void
    {
        Pizza::destroy($id);
    }
}
