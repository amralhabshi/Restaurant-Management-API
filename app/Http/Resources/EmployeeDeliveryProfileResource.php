<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeDeliveryProfileResource extends JsonResource
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

            'commission_amount' => $this->commission_amount,

            'is_available' => $this->is_available,

            'employee' => new EmployeeResource(
                $this->whenLoaded('employee')
            ),

        ];
    }
}
