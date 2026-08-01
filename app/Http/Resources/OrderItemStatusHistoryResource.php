<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemStatusHistoryResource extends JsonResource
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

            'old_status' => $this->old_status,

            'new_status' => $this->new_status,

            'notes' => $this->notes,

            'changed_at' => $this->changed_at,

            'order_item' => new OrderItemResource(
                $this->whenLoaded('orderItem')
            ),

            'employee' => new EmployeeResource(
                $this->whenLoaded('employee')
            ),

        ];
    }
}