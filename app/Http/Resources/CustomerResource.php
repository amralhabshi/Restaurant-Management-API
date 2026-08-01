<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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

            'first_name' => $this->first_name,

            'last_name' => $this->last_name,

            'phone' => $this->phone,

            'email' => $this->email,

            'birth_date' => $this->birth_date,

            'wallet' => new WalletResource(
                $this->whenLoaded('wallet')
            ),

            'orders' => OrderResource::collection(
                $this->whenLoaded('orders')
            ),

            'reservations' => ReservationResource::collection(
                $this->whenLoaded('reservations')
            ),

            'refunds' => RefundResource::collection(
                $this->whenLoaded('refunds')
            ),

        ];
    }
}
