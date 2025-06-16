<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PizzaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'pizza_id' => $this->pizza_id,
            'pizza_type_id' => $this->pizza_type_id,
            'size' => $this->size,
            'price' => $this->price,
            'pizza_type' => new PizzaTypeResource($this->whenLoaded('pizzaType')),
        ];
    }
}
