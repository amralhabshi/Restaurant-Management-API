<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryZoneResource extends JsonResource
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

            'name' => $this->name,

            'description' => $this->description,

            'delivery_fee' => $this->delivery_fee,

            'branch' => new BranchResource(
                $this->whenLoaded('branch')
            ),

            'employees' => EmployeeResource::collection(
                $this->whenLoaded('employees')
            ),

            'deliveries' => DeliveryResource::collection(
                $this->whenLoaded('deliveries')
            ),

        ];
    }
}
