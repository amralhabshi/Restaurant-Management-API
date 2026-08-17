<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource
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

            'customer_name' => $this->customer_name,

            'customer_phone' => $this->customer_phone,

            'customer_address' => $this->customer_address,

            'delivery_address' => $this->delivery_address,

            'status' => $this->status?->value,

            'payment_status' => $this->payment_status,

            'cash_collected' => $this->cash_collected,

            'picked_up_at' => $this->picked_up_at,

            'delivered_at' => $this->delivered_at,

            'order' => new OrderResource(
                $this->whenLoaded('order')
            ),

            'employee' => new EmployeeResource(
                $this->whenLoaded('employee')
            ),

            'delivery_zone' => new DeliveryZoneResource(
                $this->whenLoaded('deliveryZone')
            ),

            'status_histories' => DeliveryStatusHistoryResource::collection(
                $this->whenLoaded('statusHistories')
            ),

        ];
    }
}
