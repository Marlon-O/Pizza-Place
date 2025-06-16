<?php

namespace App\Services;

use App\Models\PizzaType;
use Spatie\QueryBuilder\QueryBuilder;

class PizzaTypeService
{
    public function all()
    {
        return QueryBuilder::for(PizzaType::class)
            ->allowedFilters(['pizza_type_id', 'name', 'category'])
            ->allowedSorts(['pizza_type_id', 'name'])
            ->paginate(20);
    }

    public function create(array $data)
    {
        return PizzaType::create($data);
    }

    public function show(string $id)
    {
        return PizzaType::with('pizzas')->findOrFail($id);
    }

    public function update(string $id, array $data)
    {
        $type = PizzaType::findOrFail($id);
        $type->update($data);
        return $type;
    }

    public function delete(string $id): void
    {
        PizzaType::destroy($id);
    }
}
