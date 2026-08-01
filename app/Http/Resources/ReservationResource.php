<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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

            'start_time' => $this->start_time,

            'duration_in_minutes' => $this->duration_in_minutes,

            'end_time' => $this->end_time,

            'total_price' => $this->total_price,

            'guest_count' => $this->guest_count,

            'status' => $this->status,

            'is_converted' => $this->isConverted(),

            'employee' => new EmployeeResource(
                $this->whenLoaded('employee')
            ),

            'customer' => new CustomerResource(
                $this->whenLoaded('customer')
            ),

            'tables' => TableResource::collection(
                $this->whenLoaded('tables')
            ),

            'order' => new OrderResource(
                $this->whenLoaded('order')
            ),
        ];
    }
}