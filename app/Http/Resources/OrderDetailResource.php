<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_details_id' => $this->order_details_id,
            'order_id' => $this->order_id,
            'pizza_id' => $this->pizza_id,
            'quantity' => $this->quantity,
            'pizza' => new PizzaResource($this->whenLoaded('pizza')),
        ];
    }
}
