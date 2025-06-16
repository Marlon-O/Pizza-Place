<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PizzaTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'pizza_type_id' => $this->pizza_type_id,
            'name' => $this->name,
            'category' => $this->category,
            'ingredients' => $this->ingredients,
            'pizzas' => PizzaResource::collection($this->whenLoaded('pizzas')),
        ];
    }
}
