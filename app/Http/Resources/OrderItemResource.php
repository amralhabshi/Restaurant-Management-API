<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * 
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'quantity' => $this->quantity,

            'unit_price' => $this->unit_price,

            'notes' => $this->notes,

            'type' => $this->type,

            'order' => new OrderResource(
                $this->whenLoaded('order')
            ),

            'menu_item' => new MenuItemResource(
                $this->whenLoaded('menuItem')
            ),

            'status_histories' => OrderItemStatusHistoryResource::collection(
                $this->whenLoaded('statusHistories')
            ),

        ];
    }
}