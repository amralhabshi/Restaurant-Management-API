<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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

            'amount' => $this->amount,

            'method' => $this->method?->value,

            'status' => $this->status?->value,

            'paid_at' => $this->paid_at,

            'invoice' => new InvoiceResource(
                $this->whenLoaded('invoice')
            ),

        ];
    }
}
