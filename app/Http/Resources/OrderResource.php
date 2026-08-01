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

            'id' => $this->id,

            'order_number' => $this->order_number,

            'type' => $this->type,

            'status' => $this->status,

            'total_price' => $this->total_price,

            'notes' => $this->notes,

            'branch' => new BranchResource(
                $this->whenLoaded('branch')
            ),

            'employee' => new EmployeeResource(
                $this->whenLoaded('employee')
            ),

            'customer' => new CustomerResource(
                $this->whenLoaded('customer')
            ),

            'table' => new TableResource(
                $this->whenLoaded('table')
            ),

            'reservation' => new ReservationResource(
                $this->whenLoaded('reservation')
            ),

            'order_items' => OrderItemResource::collection(
                $this->whenLoaded('orderItems')
            ),

            'invoice' => new InvoiceResource(
                $this->whenLoaded('invoice')
            ),

            'delivery' => new DeliveryResource(
                $this->whenLoaded('delivery')
            ),

        ];
    }
}