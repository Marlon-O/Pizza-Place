<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_id' => $this->order_id,
            'date' => $this->date,
            'time' => $this->time,
            'details' => OrderDetailResource::collection($this->whenLoaded('orderDetails')),
        ];
    }
}
