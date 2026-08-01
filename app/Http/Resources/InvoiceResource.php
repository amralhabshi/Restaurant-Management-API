<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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

            'invoice_number' => $this->invoice_number,

            'subtotal' => $this->subtotal,

            'tax' => $this->tax,

            'discount' => $this->discount,

            'total' => $this->total,

            'refunded_total' => $this->refunded_total,

            'issued_at' => $this->issued_at,

            'order' => new OrderResource(
                $this->whenLoaded('order')
            ),

            'payments' => PaymentResource::collection(
                $this->whenLoaded('payments')
            ),

            'refunds' => RefundResource::collection(
                $this->whenLoaded('refunds')
            ),

        ];
    }
}
